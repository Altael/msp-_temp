<?php

namespace App\Http\Controllers;

use App\Http\Resources\MissingLessonsResource;
use App\Repositories\MeditationLessons\MissingLessonsRepository;
use App\Services\MeditationLessons\MeditationLessonsService;
use Illuminate\Http\Request;

class MissingLessonsController extends Controller
{
    public function index(MissingLessonsRepository $repository)
    {
        $request = MissingLessonsResource::collection($repository->getAll(request('skip', 0), request('take', 10)));

        $total = $repository->getCount();

        return [
            'requests' => $request,
            'total' => $total
        ];
    }

    public function accept(
        MissingLessonsRepository $repository,
        MeditationLessonsService $meditationLessonsService
    )
    {
        $repository->update(request('data')['id']);

        dd(request('data'));


        return [
            'status' => "ok",
        ];
    }

    public function decline(MissingLessonsRepository $repository)
    {
        $repository->declineRequest(request('data'));

        return [
            'status' => "ok",
        ];
    }
}
