<?php

namespace App\Services\Geolocation;

use App\Services\Geolocation\Pipes\DioceseChildrenService;
use App\Services\Geolocation\Pipes\DistrictChildrenService;
use App\Services\Geolocation\Pipes\RegionChildrenService;
use App\Services\Geolocation\Pipes\SectorChildrenService;
use Illuminate\Pipeline\Pipeline;

class GeolocationService
{
    public const SECTOR = 'sector';
    public const REGION = 'region';
    public const DIOCESE = 'diocese';
    public const DISTRICT = 'district';
    public const DISTRICT_AREA = 'district_area';
    public const UNIT = 'unit';

    private const PIPES = [
        SectorChildrenService::class,
        RegionChildrenService::class,
        DioceseChildrenService::class,
        DistrictChildrenService::class
    ];

    /**
     * @var Pipeline
     */
    private $pipeline;

    /**
     * GeolocationService constructor.
     * @param Pipeline $pipeline
     */
    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * @param array $geoRegions
     * @return array
     */
    public function getChildren(array $geoRegions): array
    {
        return $this->pipeline
            ->send($geoRegions)
            ->through(self::PIPES)
            ->thenReturn();
    }
}
