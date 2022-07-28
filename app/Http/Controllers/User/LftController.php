<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lft\LftRequest;
use App\Models\User\User;
use App\Services\User\LftService;
use Illuminate\Http\JsonResponse;

class LftController extends Controller
{
    public function update(LftRequest $lftRequest)
    {
        $user = User::findOrFail($lftRequest->get('userId'));

        $status = '';

        switch($user->lft) {
            case ('LT'):
            case('SH'):
                $status = 'PL';
                break;
            case('PL'):
                $status = 'LT';
                break;
        }

        $user->update([
            'lft' => $status
        ]);
    }
}
