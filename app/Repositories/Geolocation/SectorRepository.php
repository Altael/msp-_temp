<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\SectorRepositoryInterface;
use App\Models\Geolocation\Sector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SectorRepository implements SectorRepositoryInterface
{

    protected $model;

    public function getAll(): Collection
    {
        return Sector::all();
    }

    public function getAllWithAcaryas(): Collection
    {
        return Sector::with('acaryas')->get();
    }

    public function model(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    public function store(string $name, array $acaryas, ?string $notes): bool
    {
        $sector = Sector::create([
            'name' => $name,
            'notes' => $notes
        ]);

        $sector->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return !!$sector;
    }

    public function update(int $id, string $name, array $acaryas, ?string $notes): int
    {
        $sector = Sector::where('id', $id)->firstOrFail();

        $sector->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return $sector->update(['name' => $name, 'notes' => $notes]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $sector = Sector::find($id);
            $sector->acaryas()->detach();
            return $sector->delete();
        });
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getAllChildren(array $ids): array
    {
        $sectors = Sector::query()
            ->whereIn('id', $ids)
            ->get();

        $result = [];
        foreach ($sectors as $sector) {
            $result[] = $sector->regions()->pluck('id')->toArray();
        }

        if (empty($result)) {
            return [];
        }

        return array_merge(...$result);
    }
}
