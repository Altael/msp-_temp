<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\DioceseRepositoryInterface;
use App\Models\Geolocation\Diocese;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DioceseRepository implements DioceseRepositoryInterface
{

    public function store(int $regionId, string $name, array $acaryas, ?string $notes): bool
    {
        $diocese = Diocese::create([
            'region_id' => $regionId,
            'name' => $name,
            'notes' => $notes
        ]);

        $diocese->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return !!$diocese;
    }

    public function update(int $id, string $name, array $acaryas, ?string $notes): int
    {
        $diocese = Diocese::where('id', $id)->firstOrFail();

        $diocese->acaryas()->sync(Arr::pluck($acaryas, 'id'));

        return $diocese->update(['name' => $name, 'notes' => $notes]);
    }

    public function delete(int $id): int
    {
        return \DB::transaction(function () use ($id) {
            $diocese = Diocese::find($id);
            $diocese->acaryas()->detach();
            return $diocese->delete();
        });
    }

    public function getAll(): Collection
    {
        $dioceses = Diocese::query();

        if ($id = request('regionId')) {
            $dioceses->where('region_id', $id);
        }

        return $dioceses->get();
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getAllChildren(array $ids): array
    {
        $dioceses = Diocese::query()
            ->whereIn('id', $ids)
            ->get();

        $result = [];
        foreach ($dioceses as $diocese) {
            $result[] = $diocese->districts()->pluck('id')->toArray();
        }

        if (empty($result)) {
            return [];
        }

        return array_merge(...$result);
    }
}
