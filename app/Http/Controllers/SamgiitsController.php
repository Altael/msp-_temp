<?php

namespace App\Http\Controllers;

use App\DailyReward;
use App\Fasting;
use App\Http\Resources\DailyRewardDisplayResource;
use App\Http\Resources\DailyRewardsResource;
use App\Http\Resources\FastingsResource;
use App\Repositories\Handbooks\FastingsRepository;
use App\Repositories\Handbooks\PuzzlesRepository;
use App\Repositories\Handbooks\SamgiitsRepository;
use App\Samgit;
use Illuminate\Http\Request;

class SamgiitsController extends Controller
{
    public function index(SamgiitsRepository $repository)
    {
        $samgiits = [];

        if($samgiit = request('samgiit')) {
            $samgiits[] = Samgit::where('samgiita_number', $samgiit)->with('media')->first();
            $total = 1;
        } else {
            $samgiits = $repository->getAll(request('skip', 0), request('take', 10));
            $total = $repository->getCount();
        }

        return [
            'samgiits' => $samgiits,
            'total' => $total
        ];
    }

    public function store()
    {
        $item = request('samgiit');

        $media = array_column($item['media'], 'id');

        unset($item['media']);

        if ($item['id'] !== null) {
            $name = Samgit::where('id', $item['id'])->first();
            $name->update($item);
            $name->media()->sync($media);
        } else {
            Samgit::create($item);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id)
    {
        $name = Samgit::where('id', $id);
        $name->delete();

        return [
            'status' => 'ok'
        ];
    }
}
