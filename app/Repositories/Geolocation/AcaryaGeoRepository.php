<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\AcaryaGeoRepositoryInterface;
use App\Models\Geolocation\AcaryaGeo;

class AcaryaGeoRepository implements AcaryaGeoRepositoryInterface
{
    /**
     * @param int $acaryaId
     * @return array
     */
    public function getByAcaryaId(int $acaryaId): array
    {
        return AcaryaGeo::query()
            ->from('acarya_geo')
            ->select('geo_id', 'type')
            ->where('acarya_id', $acaryaId)
            ->get()
            ->toArray();
    }
}
