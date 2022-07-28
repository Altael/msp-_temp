<?php

namespace App\Repositories\User;

use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Contracts\User\UserProfileRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Events\UserAddedToUnit;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Services\Geolocation\DistrictAreaService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    /**
     * @var DistrictAreaService
     */
    private $districtAreaService;

    /**
     * UserProfileRepository constructor.
     * @param DistrictAreaService $districtAreaService
     */
    public function __construct(
        DistrictAreaService $districtAreaService
    ) {
        $this->districtAreaService = $districtAreaService;
    }

    /**
     * @param array $data
     * @return UserProfile
     */
    public function save(array $data): UserProfile
    {
        return UserProfile::create($data);
    }

    /**
     * @param int $userId
     * @return UserProfile|null
     */
    public function findByUserId(int $userId): ?UserProfile
    {
        return UserProfile
            ::where('user_id', $userId)
            ->first();
    }

    public function update(int $userId, array $data): bool
    {
        $userProfile = UserProfile::where('user_id', $userId)->first();

        $data['hash_id'] = md5($userProfile->user->id);

        $data['eula'] = $data['eula'] ?? false;
        $data['english'] = $data['english'] ?? false;
        $data['birthday'] = isset($data['birthday']) ? Carbon::create($data['birthday']) : false;

        if(isset($data['notes'])) User::where('id', $userId)->update(['notes' => $data['notes']]);

        //$place_works = $place_id = $data['place_id'] && $userProfile->place_id !== $data['place_id'];

        $result = $userProfile->update(\Arr::except($data, ['notes']));

        /*if($place_works) {
            $user = $userProfile->user()->first();

            $districtArea = $user->districtArea;

            if ($unitId = $districtArea['default_unit_id']) {
                $user->units()->sync([$unitId]);
                try {
                    event(new UserAddedToUnit($userId, $unitId));
                } catch (\Exception $e) {
                    echo 'Сообщение секретарю не отправлено';
                }
            }
        }*/

        return $result;
    }

    public function updateImage(int $userId, ?string $image)
    {
        $profile = UserProfile::firstOrCreate(['user_id' => $userId]);

        return (bool)$profile->update(['image' => $image]);
    }

    /**
     * @param int $userId
     * @param array $geoRegions
     * @return array
     */
    public function getAcaryasByGeoRegions(int $userId, array $geoRegions): array
    {
        $builder = UserProfile::query()
            ->select('user_profiles.user_id', 'user_profiles.sex', 'user_profiles.spiritual_name')
            ->from('user_profiles')
            ->join('role_user as r', 'r.user_id', '=', 'user_profiles.user_id')
            ->join('acarya_geo as ag', 'ag.acarya_id', '=', 'user_profiles.user_id')
            ->where('r.role_id', '=', 2)
            ->where('user_profiles.user_id', '!=', $userId)
            ->groupBy('user_profiles.user_id');

        $builder->where(static function ($q) use ($geoRegions) {
            /** @var  $q Builder */
            foreach ($geoRegions as $type => $geoIds) {
                $q->orWhere(static function ($q) use ($type, $geoIds) {
                    /** @var  $q Builder */
                    $q->where('ag.type', $type);
                    $q->whereIn('ag.geo_id', $geoIds);
                });
            }
        });

        return $builder->get()->toArray();
    }
}
