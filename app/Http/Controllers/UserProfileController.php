<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeditationLessons\ChangeSpiritualNameRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\SpiritualNamesToProfileResource;
use App\Http\Resources\UserCabinetResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Traits\HistoryTrait;
use App\Repositories\Handbooks\SpiritualNamesRepository;
use App\Repositories\User\UserRepository;
use App\Services\Geolocation\DistrictAreaService;
use App\Services\User\AcaryasService;
use App\Services\User\UserProfilesService;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    use HistoryTrait;

    public function edit(UserProfilesService $userProfilesService, SpiritualNamesRepository $spiritualNamesRepository, UserRepository $userRepository)
    {
        $user = auth()->user();
        $profile = $user->profile;
        $profile['place'] = optional($profile->place);
        $roles = $user->roles;
        $registrationCompleted = $user->registration_completed;

        /*if(!$registrationCompleted) {
            $profile->email = $user->email ?? '';
            $name = explode(' ',$user->name);
            $profile->first_name = $name[0];
            if(count($name)>1) {
                $profile->last_name = $name[1];
            }
        }*/

        if(!$registrationCompleted) {
            $profile->hash_id = md5($user->id);
        }

        $spiritual_names = SpiritualNamesToProfileResource::collection($spiritualNamesRepository->getAllForUser());

        return [
            'status' => 'ok',
            'profile' => $profile,
            'roles' => $roles,
            'registration' => $registrationCompleted,
            'spiritual_names' => $spiritual_names,
            'mobileId' => auth()->user()->mobile_id,
            'acarya' => $user->teacher ? new UserIdDisplayNameResource($user->teacher) : ['id' => null, 'name' => __("My acarya is not on the list")],
            'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
        ];
    }

    /**
     * @param UpdateProfileRequest $updateProfileRequest
     * @param UserProfilesService $userProfilesService
     * @param DistrictAreaService $districtAreaService
     * @return array
     * @throws \Exception
     */
    public function update(UpdateProfileRequest $updateProfileRequest, UserProfilesService $userProfilesService, DistrictAreaService $districtAreaService)
    {
        $user = auth()->user();
        $registrationCompleted = $user->registration_completed;
        /*if($user->profile->place_id !== $updateProfileRequest->place_id) {
            if ($districtAreaId  = $districtAreaService->findByPlaceId($updateProfileRequest->place_id)) {
                $user->update([
                    'district_area_id' => $districtAreaId
                ]);
            }
        }*/
        if($updateProfileRequest['teacher']['id']) {
            $user->teachers()->sync([$updateProfileRequest['teacher']['id']]);
        } else {
            $user->teachers()->sync([]);
        }
        $userProfilesService->updateUserProfile(
            $user->id,
            $updateProfileRequest->except(['id', '_token', 'place', 'user', 'displayName', 'averageDiary', 'privateName', 'teacher']),
            $registrationCompleted
        );

        if ($registrationCompleted) {
            return [
                'status' => 'ok'
            ];
        }

        return redirect('/');
    }

    public function nulifyNameNotification()
    {
        auth()->user()->update(['notify_name' => 0]);
        return [
            'status' => 'ok'
        ];
    }

    /**
     * @param ChangeSpiritualNameRequest $request
     * @param UserProfilesService $userProfilesService
     * @return JsonResponse
     */
    public function changeInitiationUser(
        ChangeSpiritualNameRequest $request,
        UserProfilesService $userProfilesService
    ): JsonResponse {
        $result = $userProfilesService->changeInitiationUser($request->get('userId'), $request->get('spiritualName'), $request->get('notes', ' '));
        return response()->json(['result' => $result]);
    }

    /**
     * @param AcaryasService $acaryasService
     * @return JsonResponse
     */
    public function getAcaryas(AcaryasService $acaryasService): JsonResponse
    {
        return response()->json(['result' => $acaryasService->getAcaryasByGeoRegions(auth()->user()->id)]);
    }

    public function cab()
    {
        $user_info = new UserCabinetResource(auth()->user()->profile);

        return [
            'userInfo' => $user_info
        ];
    }

    public function setPracticesDifficulty()
    {
        return (bool)auth()->user()->profile->update([
            'practices_diff' => request('diff')
        ]);
    }

    public function setFastingsAmount()
    {
        return (bool)auth()->user()->profile->update([
            'fasting' => request('fasting')
        ]);
    }

    public function setSex()
    {
        return (bool)auth()->user()->profile->update([
            'sex' => request('sex')
        ]);
    }

    public function confirm100hours()
    {
        $profile = auth()->user()->profile->fill([
            'meditation_hours' => 100
        ]);

        $this->saveHistoryLog('confirm-100-hours-of-meditation', $profile, $profile->getOriginal());

        $profile->save();

        return [
            'result' => 'you cool now'
        ];
    }
}
