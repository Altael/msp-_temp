<?php

namespace App\Repositories\User;

use App\Contracts\User\AcaryaHelperRepositoryInterface;
use App\Models\User\AcaryaHelper;
use Illuminate\Support\Facades\DB;

class AcaryaHelperRepository implements AcaryaHelperRepositoryInterface
{
    /**
     * @param int $helperId
     * @return array
     */
    public function getAcaryasByHelperId(int $helperId): array
    {
        return AcaryaHelper::query()
            ->select(
                'ah.acarya_id as id',
                DB::raw("CONCAT_WS(' ', p.first_name, p.last_name, p.middle_name) as name")
            )
            ->from('acarya_helper as ah')
            ->join('user_profiles as p', 'p.user_id', '=', 'ah.acarya_id')
            ->where('helper_id', '=', $helperId)
            ->get()
            ->toArray();
    }
}
