<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\RegionRepositoryInterface;
use App\Models\Geolocation\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RegionRepository implements RegionRepositoryInterface
{

    protected $model;

    public function getAll(): Collection
    {
        $regions = Region::query();

        if ($id = request('sectorId')) {
            $regions->where('sector_id', $id);
        }

        return $regions->get();
    }

    public function model(Model $model) {
        $this->model = $model;
        return $this;
    }

    public function store(int $sectorId, string $name, array $acaryas, ?string $notes): bool
    {
        $region = Region::create([
            'sector_id' => $sectorId,
            'name' => $name,
            'notes' => $notes
        ]);

        $region->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return !!$region;
    }

    public function update(int $id, string $name, array $acaryas, ?string $notes): int
    {
        $region = Region::where('id', $id)->firstOrFail();

        $region->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return $region->update(['name' => $name, 'notes' => $notes]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $region = Region::find($id);
            $region->acaryas()->detach();
            return $region->delete();
        });
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getAllChildren(array $ids): array
    {
        $regions = Region::query()
            ->whereIn('id', $ids)
            ->get();

        $result = [];
        foreach ($regions as $region) {
            $result[] = $region->dioceses()->pluck('id')->toArray();
        }

        if (empty($result)) {
            return [];
        }

        return array_merge(...$result);
    }
}
