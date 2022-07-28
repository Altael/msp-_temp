<?php

namespace App\Http\Controllers;

use App\Fasting;
use App\Http\Resources\FastingsResource;
use App\Http\Resources\NearestFastingsResource;
use App\Repositories\Handbooks\FastingsRepository;
use Illuminate\Http\Request;

class FastingsController extends Controller
{
    public function index(FastingsRepository $repository)
    {
        $fastings = FastingsResource::collection($repository->getAll(request('skip', 0), request('take', 10), request('infinite', false)));

        $total = $repository->getCount();

        $amount = auth()->user()->profile->fasting;

        return [
            'fastings' => $fastings,
            'total' => $total,
            'amount' => $amount
        ];
    }

    public function nearestFasting(FastingsRepository $repository)
    {
        $fasting = new NearestFastingsResource($repository->getNearestSolo());

        return [
            'fasting' => $fasting
        ];
    }
}
