<?php

namespace App\Http\Controllers;

use App\Call;
use App\Events\UserAddedToUnit;
use App\Http\Resources\CallRequestsDisplayResource;
use App\Http\Resources\CallRequestsResource;
use App\Http\Resources\UnitInfoResource;
use App\Http\Resources\UserEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UserEditRolesResource;
use App\Http\Resources\UserHistoryResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Resources\UserListResource;
use App\Http\Resources\UsersStatusesResource;
use App\Http\Resources\UserToolsResource;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Repositories\Geolocation\DistrictRepository;
use App\Repositories\Geolocation\UnitRepository;
use App\Repositories\User\AcaryaHelperRepository;
use App\Repositories\User\UserRepository;
use App\Status;
use App\UnitTitle;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersController extends Controller
{
    public function index(UserRepository $repository, DistrictRepository $districtRepository, UnitRepository $unitRepository)
    {
        $result = [];

        $total_users = User::where('hidden', false)->where(function($q) {
            $q->where('registration_completed', true)
                ->orWhere('fake', true);
        })->count();

        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('watcher') || auth()->user()->hasRole('dean')) {

            $result = UserListResource::collection($repository->getAllForUserList(request('skip', 0), request('take', 10)))->additional([
                'meta' => [
                    'total' => $repository->total(),
                    'total_users' => $total_users,
                    'units' => $unitRepository->getAll()
                ]
            ]);
        }

        elseif (auth()->user()->hasRole('curator')) {
            $diocese_info = $repository->getAllInDiocese(request('skip', 0), request('take', 10));

            $result = UserListResource::collection($diocese_info['users'])->additional([
                'meta' => [
                    'total_users' => $total_users,
                    'total' => $diocese_info['total']
                ]
            ]);
        }

        elseif (auth()->user()->hasRole('bp')) {
            $bhuktiInfo = $repository->getAllInBhukti(request('skip', 0), request('take', 10));

            $result = UserListResource::collection($bhuktiInfo['users'])->additional([
                'meta' => [
                    'total' => $bhuktiInfo['total'],
                    'total_users' => $total_users,
                    'units' => $districtRepository->getAllUnitsOfBP(auth()->user()->id)
                ]
            ]);
        }

        elseif (auth()->user()->hasRole('secretary')) {
            $result = UserListResource::collection($repository->getAllForUnits(request('skip', 0), request('take', 10)))->additional([
                'meta' => [
                    'total_users' => $total_users,
                    'total' => $repository->totalInUnits()
                ]
            ]);
        }

        return $result;
    }

    public function show(UserRepository $repository, User $user)
    {
        $roles = auth()->user()->accessed_roles;

        $roles->map( function ($role) use ($user) {
            $role->sex = $user->profile ? $user->profile->sex : 'male';
        });

        $area_units = optional($user->districtArea)->units;

        return (new UserEditResource($user))->additional([
            'meta' => [
                'roles' => UserEditRolesResource::collection(Role::all()),
                'editable_roles' => UserEditRolesResource::collection($roles),
                'acaryas' => UserIdDisplayNameResource::collection($repository->getAllAcaryas()),
                'social' => session('userSocial', 'mail'),
                'area_units' => $area_units,
                'history' => UserHistoryResource::collection($user->historyEvents)
            ]
        ]);
    }

    public function update(User $user)
    {
        $data = request('data');
        $user->update([
            'notes' => $data['notes']
        ]);
        $user->profile->update([
            'unit_alias' => $data['unit_alias'],
            'phone_system' => $data['phone_system'] ?? $user->profile->phone_system,
            'email_system' => $data['email_system'] ?? $user->profile->email_system,
            'telegram_system' => $data['telegram_system'] ?? $user->profile->telegram_system
        ]);

        $data_roles = Arr::pluck($data['roles'], 'id');

        $user->roles()->syncWithoutDetaching($data_roles);
        $user->units()->sync([$data['unit']['id']]);

        foreach($user->roles as $role) {
            if(!in_array($role->id, $data_roles) && in_array($role->id, auth()->user()->accessed_roles->pluck('id')->toArray()))
                $user->roles()->detach($role->id);
        }

        $user->acaryas()->sync(Arr::pluck($data['acaryas'], 'id'));
        $user->dioceses()->sync(Arr::pluck($data['dioceses'], 'id'));
        if($data['status']) {
            $user->statuses()->sync([$data['status']['id']]);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function saveRoles()
    {
        $user = auth()->user();

        if($user->hasPermission('cheatWithRoles')) {
            $roles = request('roles');

            $user->roles()->sync(Arr::pluck($roles, 'id'));

            return [
                'status' => 'ok'
            ];
        } else {
            return [
                'status' => 'Ты кто такой, ****, чтобы это делать?'
            ];
        }
    }

    public function store()
    {
        $userId = request('userId');
        $unitId = request('unitId');

        $user = User::where('id', $userId)->firstOrFail();

        $user->units()->sync([$unitId]);

        try {
            event(new UserAddedToUnit($userId, $unitId));
        } catch (\Exception $e) {
            dd('Сообщение секретарю не отправлено');
        }

        return [
            'status' => 'ok'
        ];
    }

    public function setLocale($locale)
    {
        auth()->user()->update([
            'language' => $locale
        ]);

        return redirect()->back();
    }

    public function switch(\App\Models\User\User $user)
    {
        auth()->login($user);
        return redirect()->back();
    }

    public function titleProcedure()
    {
        $user = User::find(request('params.user_id'));
        $title = UnitTitle::find(request('params.title_id'));
        $former_title = UnitTitle::find($user->unit->pivot->title_id);

        $secretary_role = Role::where('slug', 'secretary')->first();

        if($title && $title->id) {
            $user->roles()->attach($secretary_role->id);

            $user->units()->updateExistingPivot($user->unit->id, [
                'title_id' => $title->id
            ]);

            if($title->slug === 'sunit') {
                $user->unit->update([
                    'secretary_id' => $user->id
                ]);
            }
        } else {
            $user->roles()->detach($secretary_role->id);

            $user->units()->updateExistingPivot($user->unit->id, [
                'title_id' => null
            ]);
        }

        if(($former_title && $former_title->slug === 'sunit') && (!$title || $title->slug !== 'sunit')) {
            $user->unit->update([
                'secretary_id' => null
            ]);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function connectMobileApp()
    {
        $client = new Client([
            'base_uri' => 'https://xn--80ahclcbajtrv5ae6c.xn--p1ai/msp/v1/'
        ]);


        $user = auth()->user();

        $socials = $user->socials->map(function ($social) {
            return [
                'type' => $social->provider,
                'id' => $social->social_id,
            ];
        });

        $response = $client->post('identify-user', [
            'json' => [
                "hash" => "secret hash",
                "ids" => $socials->toArray()
            ]
        ]);

        $result = \GuzzleHttp\json_decode($response->getBody(), true);

        $user_mobile_id = $result['id'];

        $user->update([
            'mobile_id' => $user_mobile_id
        ]);

        return [
            'id' => $user_mobile_id,
            'status' => 'ok'
        ];
    }

    public function disconnectMobileApp()
    {
        auth()->user()->update([
            'mobile_id' => null
        ]);

        return [
            'status' => 'ok'
        ];
    }

    public function getUserPractices()
    {
        $start = request('start', Carbon::today()->format('Y-m-d'));
        $end = request('end', Carbon::today()->format('Y-m-d'));

        $client = new Client([
            'base_uri' => 'https://xn--80ahclcbajtrv5ae6c.xn--p1ai/msp/v1/'
        ]);

        $user = auth()->user();

        $response = $client->post('get-practices', [
            'json' => [
                "hash" => "secret hash",
                "id" => $user->mobile_id,
                "start" => $start,
                "end" => $end
            ]
        ]);

        $result = \GuzzleHttp\json_decode($response->getBody(), true);

        return $result;
    }

    public function saveUnitSettings() {
        $data = request('member');
        $unit = auth()->user()->unit;

        $status_id = $data['status']['id'];

        if($user_id = $data['id']) {
            $user = User::findOrFail($user_id);

            $user->update([
                'notes' => $data['notes']
            ]);

            $user->profile->update([
                'unit_alias' => $data['unit_alias'] ?? null,
                'image_system' => $data['image_system'] ?? null,
                'telegram_system' => $data['telegram_system'] ?? null,
                'email_system' => $data['email_system'] ?? null,
                'phone_system' => $data['phone_system'] ?? null
            ]);

            $programmer_id = Role::where('slug', 'programmer')->first()->id;

            if($data['is_programmer']) $user->roles()->attach($programmer_id);
            else $user->roles()->detach($programmer_id);
        } else {
            $user = User::create([
                'notes' => $data['notes'] ?? null,

                'district_area_id' => $unit->districtArea->id,
                'fake' => true
            ]);

            $user_profile = UserProfile::create([
                'user_id' => $user->id,
                'hash_id' => md5($user->id),
                'place_id' => $unit->disctrict_area,

                'unit_alias' => $data['unit_alias'] ?? null,
                'image_system' => $data['image_system'] ?? null,
                'telegram_system' => $data['telegram_system'] ?? null,
                'email_system' => $data['email_system'] ?? null,
                'phone_system' => $data['phone_system'] ?? null
            ]);

            $user->units()->sync([$unit->id]);
        }

        $user->statuses()->sync([$status_id]);

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id) {
        $user = User::findOrFail($id);

        $user->delete();

        return [
            'status' => 'sad'
        ];
    }

    public function getUserData($id) {
        $user = new UserToolsResource(User::findOrFail($id));

        return [
            'user' => $user,
            'admin' => auth()->user()->hasRole('admin')
        ];
    }

    public function getCurators() {

    }

    public function getRoles() {
        $roles = [];

        foreach(Role::all() as $role) {
            $roles[$role['slug']] = __($role['name']);
        }

        return [
            'roles' => $roles
        ];
    }

    public function info()
    {
        $user = auth()->user();

        return [
            'permissions' => $user->userPermissions()->get()->merge($user->rolePermissions()->get())->pluck('slug'),
            'roles' => $user->getRoles()->pluck('slug'),
            'sadvipra' => $user->sadvipra,
            'name' => optional($user->profile)->first_name ?? $user->name,
            'meditation_hours' => optional($user->profile)->meditation_hours ?? 0,
            'current_lesson' => $user->lessons()->count(),
            'spiritual_name' => optional($user->profile)->spiritual_name ?? null,
            'first_name' => optional($user->profile)->first_name ?? null,
            'last_name' => optional($user->profile)->last_name ?? null,
            'phone' => optional($user->profile)->phone,
            'telegram' => (bool)optional($user->profile)->telegram_id,
            'requests' => [
                'calls' => array_map(function($call) {return Call::find($call['call_id'])->slug;}, $user->callRequests->toArray()),
                'calls_details' => CallRequestsDisplayResource::collection($user->callRequests)
            ]
        ];
    }
}
