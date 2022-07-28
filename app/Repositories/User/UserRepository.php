<?php

namespace App\Repositories\User;

use App\Contracts\User\UserRepositoryInterface;
use App\Models\Geolocation\District;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use App\Status;
use App\UnitTitle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        $user = User::create($data);

        $status_id = Status::where('name_en', 'Unit')->first()->id;

        $user->statuses()->sync([$status_id]);

        return $user;
    }

    /**
     * @param string $email
     * @return int
     */
    public function findIdByEmail(string $email): int
    {
        return (int)User::where('email', $email)->value('id');
    }

    /**
     * @param array $type
     * @return array
     */
    public function findUsersByDistrictAreaTypes(array $type = []): array
    {
        $query = User::query()
            ->select('users.id as id', 'p.place_id as placeId')
            ->join('user_profiles as p', 'p.user_id', '=', 'users.id')
            ->leftJoin('district_areas as da', 'da.id', '=', 'users.district_area_id')
            ->whereNotNull('p.place_id');

        if (!empty($type)) {
            $query->where(static function ($query) use ($type) {
                $query->orWhereIn('da.type', $type);
                $query->orWhereNull('users.district_area_id');
            });
        } else {
            $query->whereNull('users.district_area_id');
        }

        return $query
            ->get()
            ->toArray();
    }

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function update(int $userId, array $data): bool
    {
        return (bool)User::where('id', $userId)
            ->update($data);
    }

    public function getAll($skip = 0, $take = 10): Collection
    {
        $users = User::query();

        $this->applyUserFilters($users);

        if(!request('full')) {
            $users = $users->skip($skip)->take($take)->get();
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function getAllForUserList($skip = 0, $take = 10): Collection
    {
        $users = User::with('profile.place', 'currentLesson', 'districtArea.district.diocese.region.sector', 'teachers', 'lessons', 'socials', 'roles', 'statuses');

        $this->applyUserFilters($users);

        if(!request('full')) {
            $users = $users->skip($skip)->take($take)->get();
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function getAllForUnits($skip = 0, $take = 10): Collection
    {
        $units = auth()->user()->units;

        $users = User::whereHas('units', function ($query) use ($units) {
            $query->whereIn('units.id', $units->pluck('id'));
        });

        $this->applyUserFilters($users);

        if(!request('full')) {
            $users = $users->skip($skip)->take($take)->get();
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function getAllInDiocese($skip = 0, $take = 10)
    {
        $dioceses_ids = auth()->user()->dioceses->pluck('id');

        $users = User::whereHas('districtArea.district.diocese', function ($query) use ($dioceses_ids) {
            $query->whereIn('dioceses.id', $dioceses_ids);
        });

        $this->applyUserFilters($users);

        $total = $users->count();

        if(!request('full')) {
            $users = $users->skip($skip)->take($take)->get();
        } else {
            $users = $users->get();
        }

        return [
            'users' => $users,
            'total' => $total
        ];
    }

    public function getAllInBhukti($skip = 0, $take = 10): array
    {
        $districts = auth()->user()->bpDistricts()->with('districtAreas')->get();
        $districtAreaIds = [];

        foreach ($districts as $district) {
            foreach ($district->districtAreas as $area) {
                $districtAreaIds[] = $area->id;
            }
        }

        $users = User::whereHas('districtArea', function ($query) use ($districtAreaIds) {
            $query->whereIn('district_areas.id', $districtAreaIds);
        });

        $this->applyUserFilters($users);

        $total = $users->count();

        if(!request('full')) {
            $users = $users->skip($skip)->take($take)->get();
        } else {
            $users = $users->get();
        }

        return [
            'users' => $users,
            'total' => $total
        ];
    }

    public function total()
    {
        $users = User::query();

        $this->applyUserFilters($users);

        return $users->count();
    }

    public function totalInUnits()
    {
        $units = auth()->user()->units;

        $users = User::whereHas('units', function ($query) use ($units) {
            $query->whereIn('units.id', $units->pluck('id'));
        });

        $this->applyUserFilters($users);

        return $users->count();
    }

    public function getAllAcaryas()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('slug', 'acarya');
        })->get();
    }

    public function getAllAcaryasBySex()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('slug', 'acarya');
        })->whereHas('profile', function ($query) {
            $query->where('sex', auth()->user()->profile->sex);
        })->get();
    }

    public function getAllBPs()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('slug', 'bp');
        })->get();
    }

    protected function applyUserFilters(&$users)
    {
        $users->selectRaw('users.*');

        $users->where('hidden', false);
        $users->where(function ($q) {
            $q->where('registration_completed', true)
                ->orWhere('fake', true);
        });

        if($curator = request('curator')) {
            $users->whereHas('roles', function ($q) {
                $q->where('roles.slug', 'curator');
            });
        }

        if($diocese_id = request('diocese')) {
            $users->whereHas('dioceses', function ($q) use ($diocese_id) {
                $q->where('dioceses.id', $diocese_id);
            });
        }

        if ($fake = request('fake')) {
            if($fake === 'fake') $users->where('fake', true);
            if($fake === 'not_fake') $users->where('fake', false);
        }

        if ($name = request('name')) {
            $users->whereHas('profile', function ($query) use ($name) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$name%")
                    ->orWhere('spiritual_name', 'like', "%$name%");
            });
        }

        if($statuses = request('statuses')) {
            $users->whereHas('statuses', function ($query) use ($statuses) {
                $query->whereIn('status_id', $statuses);
            });
        }

        if($title = request('title')) {
            if($title === 'all') {
                $users->whereHas('units', function ($q) use ($title) {
                    $q->where('title_id', '<>', null);
                });
            } else {
                $users->whereHas('units', function ($q) use ($title) {
                    $q->where('title_id', $title);
                });
            }
        }

        if ($city = request('city')) {
            $users->whereHas('profile', function ($query) use ($city) {
                $query->whereHas('place', function ($query) use ($city) {
                    $query->where('name_en', 'like', "%{$city}%")
                        ->orWhere('name_ru', 'like', "%{$city}%");
                });
            });
        }

        if ($country = request('country')) {
            $users->whereHas('profile', function ($query) use ($country) {
                $query->whereHas('place', function ($query) use ($country) {
                    $query->where('country', 'like', "%{$country}%");
                });
            });
        }

        if ($phone = request('phone')) {
            $users->whereHas('profile', function ($query) use ($phone) {
                $query->where('phone', 'like', "%{$phone}%");
            });
        }

        if ($email = request('email')) {
            $users->whereHas('profile', function ($query) use ($email) {
                $query->where('email', 'like', "%{$email}%");
            });
        }

        if ($profession = request('profession')) {
            $users->whereHas('profile', function ($query) use ($profession) {
                $query->where('profession', 'like', "%{$profession}%");
            });
        }

        if ($region = request('region')) {
            $users->leftJoin('district_areas', 'users.district_area_id', '=', 'district_areas.id')
                ->leftJoin('districts', 'district_areas.district_id', '=', 'districts.id')
                ->leftJoin('dioceses', 'districts.diocese_id', '=', 'dioceses.id')
                ->leftJoin('regions', 'dioceses.region_id', '=', 'regions.id')
                ->where('regions.name', 'like', "%$region%");
        }

        if ($acarya = request('acarya')) {
            $users->whereHas('teachers', function ($query) use ($acarya) {
                $query->where('name', 'like', "%{$acarya}%");
            });
        }

        if($unit = request('unit')) {
            $users->whereHas('units', function ($query) use ($unit) {
                $query->where('unit_id', $unit);
            });
        }

        if ($lesson = request('lesson')) {
            if($lesson == 7){
                $users->doesntHave('lessons');
            } else if($lesson == 8) {
                $users->whereHas('lessons');
            } else {
                $users->whereHas('lessons', function ($query) use ($lesson) {
                    $query->fromRaw("(select *, MAX(lesson_number) AS number from `meditation_lessons` GROUP BY user_id) AS meditation_lessons")
                        ->where('meditation_lessons.number', $lesson);
                });
            }
        }

        if($role = request('role')) {
            $users->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('roles.slug', '=', $role);
        }

        if($user_id = request('id')) {
            $users->whereHas('profile', function ($query) use ($user_id) {
                $query->where('hash_id', $user_id);
            })->orWhere('users.id', $user_id);
        }

        switch (request('sortBy')) {
            case 'name':
                $users->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                    ->orderBy('user_profiles.first_name', request('sortOrder', 'desc'))
                    ->orderBy('user_profiles.last_name', request('sortOrder', 'desc'));
            break;
            case 'region':
                $users->leftJoin('district_areas', 'users.district_area_id', '=', 'district_areas.id')
                    ->leftJoin('districts', 'district_areas.district_id', '=', 'districts.id')
                    ->leftJoin('dioceses', 'districts.diocese_id', '=', 'dioceses.id')
                    ->leftJoin('regions', 'dioceses.region_id', '=', 'regions.id')
                    ->orderBy('regions.name', request('sortOrder', 'desc'));
            break;
            case 'city':
                $users->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                    ->join('user_places', 'user_profiles.place_id', '=', 'user_places.id')
                    ->orderBy('user_places.name_' . app()->getLocale(), request('sortOrder', 'desc'));
            break;
            case 'initiation':
                $users->leftJoin('meditation_lessons as ml', 'users.id', '=', 'ml.user_id')
                    ->orderBy('ml.receiving_date', request('sortOrder', 'desk'));
            break;
            default:
                $users->orderBy('users.created_at', request('sortOrder', 'desc'));
        }



        // userName, region, city
    }
}
