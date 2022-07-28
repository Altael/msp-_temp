<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\UnitRepositoryInterface;
use App\Models\Geolocation\Unit;
use Illuminate\Support\Arr;

class UnitRepository implements UnitRepositoryInterface
{
    public function store(int $districtAreaId, string $name, array $acaryas, array $users, string $registration_status, ?string $notes, ?int $secretaryId)
    {
        $unit = Unit::create([
            'district_area_id' => $districtAreaId,
            'name' => $name,
            'secretary_id' => $secretaryId,
            'notes' => $notes,
            'registration_status' => $registration_status
        ]);

        $unit->acaryas()->sync(Arr::pluck($acaryas, 'id'));
        $unit->users()->sync(Arr::pluck($users, 'id'));

        return $unit;
    }

    public function update(int $id, string $name, array $acaryas, array $users, string $registration_status, ?string $notes, ?int $secretaryId): int
    {
        $unit = Unit::where('id', $id)->firstOrFail();

        $unit->acaryas()->sync(Arr::pluck($acaryas, 'id'));
        $unit->users()->sync(Arr::pluck($users, 'id'));

        return $unit->update([
            'name' => $name,
            'secretary_id' => $secretaryId,
            'notes' => $notes,
            'registration_status' => $registration_status
        ]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $unit = Unit::find($id);
            $unit->acaryas()->detach();
            return $unit->delete();
        });
    }

    public function getAll()
    {
        $units = Unit::query();

        if ($id = request('districtAreaId')) {
            $units->where('district_area_id', $id);
        }

        return $units->get();
    }
}
