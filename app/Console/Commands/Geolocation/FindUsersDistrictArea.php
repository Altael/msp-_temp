<?php

namespace App\Console\Commands\Geolocation;

use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Models\Geolocation\DistrictArea;
use App\Services\Geolocation\DistrictAreaService;
use App\Services\Geolocation\FindDistrictAreaService;
use Illuminate\Console\Command;

class FindUsersDistrictArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:find-district-areas {--full}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find users district areas';

    public function handle(FindDistrictAreaService $findDistrictAreaService, DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository)
    {
        if ($this->option('full')) {
            foreach (DistrictArea::all() as $area) {
                $districtAreaTasksRepository->save([
                    'task' => json_encode([
                        'id' => $area->id,
                        'placeId' => $area->place_id,
                        'type' => $area->type
                    ]),
                    'type' => 'district_area'
                ]);
            }
        }

        //$findDistrictAreaService->handle();
        $findDistrictAreaService->run();


    }
}
