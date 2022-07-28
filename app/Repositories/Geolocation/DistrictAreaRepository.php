<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\DistrictAreaRepositoryInterface;
use App\Models\Geolocation\DistrictArea;
use Illuminate\Support\Arr;

class DistrictAreaRepository implements DistrictAreaRepositoryInterface
{
    public function getAll()
    {
        $districts = DistrictArea::query();

        if ($id = request('districtId')) {
            $districts->where('district_id', $id);
        }

        return $districts->get();
    }

    public function store(array $params, array $acaryas): int
    {
        $area = DistrictArea::create($params);
        $area->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return $area->value('id');
    }

    public function update(int $id, string $name, string $placeId, string $type, array $acaryas, ?int $unitId, ?string $notes): int
    {
        $area = DistrictArea::where('id', $id)->firstOrFail();

        $area->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        if ($area->place_id !== $placeId) {
            $area->users()->update([
                'district_area_id' => null
            ]);
        }

        return $area->update([
            'name' => $name,
            'place_id' => $placeId,
            'type' => $type,
            'notes' => $notes,
            'default_unit_id' => $unitId
        ]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $districtArea = DistrictArea::find($id);
            $districtArea->acaryas()->detach();
            return $districtArea->delete();
        });
    }

    public function getByPlaceIdByType(string $placeId, string $type): int
    {
        return (int)DistrictArea
            ::where('place_id', $placeId)
            ->limit(1)
            ->value('id');
    }
}
