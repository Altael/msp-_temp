<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\DistrictRepositoryInterface;
use App\Http\Resources\DistrictEditResource;
use App\Http\Resources\UnitEditResource;
use App\Models\Geolocation\District;
use App\Models\Geolocation\DistrictArea;
use App\Models\Geolocation\Unit;
use App\Services\Geolocation\UserPlacesService;
use Illuminate\Support\Arr;

class DistrictRepository implements DistrictRepositoryInterface
{
    /**
     * @var UserPlacesService
     */
    private $userPlacesService;

    /**
     * DistrictAreaService constructor.
     * @param UserPlacesService $userPlacesService
     */
    public function __construct(
        UserPlacesService $userPlacesService
    ) {
        $this->userPlacesService = $userPlacesService;
    }

    public function store(int $dioceseId, string $name, array $acaryas, ?string $notes, $country_id = null): bool
    {
        $country = $country_id ? $this->districtCountryNameWorks($country_id) : null;

        $district = District::create([
            'diocese_id' => $dioceseId,
            'name' => $name,
            'notes' => $notes,
            'country' => $country
        ]);

        $district->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return !!$district;
    }

    public function update(int $id, string $name, array $acaryas, ?string $notes, $country_id = null): int
    {
        $district = District::findOrFail($id);

        $country = $country_id ? $this->districtCountryNameWorks($country_id) : $district->country;

        $district->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return $district->update([
            'name' => $name,
            'notes' => $notes,
            'country' => $country
        ]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $district = District::find($id);
            $district->acaryas()->detach();
            return $district->delete();
        });
    }

    public function getAll()
    {
        $districts = District::query();

        if ($id = request('dioceseId')) {
            $districts->where('diocese_id', $id);
        }

        if(request('empty_country')) {
            $districts->where('country', null);
        }

        return $districts->get()->sortBy('diocese_id');
    }

    public function getAllByCountries()
    {
        $countries = District::groupBy('country')->orderBy('country', 'asc')->pluck('country')->toArray();

        $lang = ['en' => 'en', 'ru' => 'ru'][app()->getLocale()] ?? 'en';

        $countries = array_pluck($countries, $lang);

        $districts = [];

        foreach($countries as $country) {
            $units = Unit::whereHas('district', function ($q) use ($lang, $country) {
                $q->where('country->' . $lang, $country);
            });

            $districts[$country]['bhuktis'] = DistrictEditResource::collection(District::where('country->' . $lang, $country)->get());
            $districts[$country]['units'] = [
                'all' => $units->count(),
                'of_reg' => (clone $units)->where('registration_status', 'of_reg')->count(),
                'not_reg' => (clone $units)->where('registration_status', 'not_reg')->count(),
                'um' => (clone $units)->where('registration_status', 'um')->count()
            ];
        }

        return $districts;
    }

    public function getAllOfBP()
    {
        return auth()->user()->bpDistricts()->get();
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getAllChildren(array $ids): array
    {
        $districts = District::query()
            ->whereIn('id', $ids)
            ->get();

        $result = [];
        foreach ($districts as $district) {
            $result[] = $district->districtAreas()->pluck('id')->toArray();
        }

        if (empty($result)) {
            return [];
        }

        return array_merge(...$result);
    }

    public function getAllUnitsOfBP($bpId)
    {
        $districts = District::where('bp_id', $bpId)->get();

        $district_areas = [];
        foreach($districts as $district) {
            foreach ($district->districtAreas()->pluck('id')->toArray() as $item) {
                $district_areas[] = $item;
            }
        }

        $units = [];
        foreach($district_areas as $district_area) {
            foreach( UnitEditResource::collection(DistrictArea::where('district_areas.id', $district_area)->first()->units()->get()) as $item)
                $units[] = $item;
        }

        return $units;
    }

    public function districtCountryNameWorks($place_id)
    {
        $name_en = $this->userPlacesService->getDetailsByPlaceId($place_id, 'en')['address_components'][0]['long_name'] ?? '';
        $name_ru = $this->userPlacesService->getDetailsByPlaceId($place_id, 'ru')['address_components'][0]['long_name'] ?? '';

        return [
            'en' => $name_en,
            'ru' => $name_ru
        ];
    }
}
