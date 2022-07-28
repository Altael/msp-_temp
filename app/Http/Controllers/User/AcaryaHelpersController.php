<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeAcaryaRequest;
use App\Services\User\UserRolesService;
use Illuminate\Http\JsonResponse;

class AcaryaHelpersController extends Controller
{
    /**
     * @param ChangeAcaryaRequest $changeAcaryaRequest
     * @param UserRolesService $userRolesService
     * @return JsonResponse
     */
    public function changeAcarya(
        ChangeAcaryaRequest $changeAcaryaRequest,
        UserRolesService $userRolesService
    ): JsonResponse {
        return response()->json(['result' => $userRolesService->changeHelperAcarya($changeAcaryaRequest->get('id'))]);
    }
}
