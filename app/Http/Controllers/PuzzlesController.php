<?php

namespace App\Http\Controllers;

use App\DailyReward;
use App\Fasting;
use App\Http\Resources\DailyRewardDisplayResource;
use App\Http\Resources\DailyRewardsResource;
use App\Http\Resources\FastingsResource;
use App\Repositories\Handbooks\FastingsRepository;
use App\Repositories\Handbooks\PuzzlesRepository;
use Illuminate\Http\Request;

class PuzzlesController extends Controller
{
    public function index(PuzzlesRepository $repository)
    {
        $puzzles = $repository->getAll(request('skip', 0), request('take', 10));

        $total = $repository->getCount();

        return [
            'puzzles' => $puzzles,
            'total' => $total
        ];
    }

    public function store()
    {
        $item = request('puzzle');

        $was_media = false;
        if($item['media']) {
            $media_id = array_column($item['media'], 'id');
            $media_lang = array_column($item['media'], 'lang');

            $media = [];

            foreach($media_id as $key => $id) {
                $media[$id] = ['lang' => $media_lang[$key]];
            }

            $was_media = true;
            unset($item['media']);
        }

        if ($item['id'] !== null) {
            $name = DailyReward::where('id', $item['id'])->first();
            $name->update($item);
            if($was_media) {
                $name->media()->sync($media);
            } else {
                $name->media()->sync([]);
            }
        } else {
            DailyReward::create($item);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id)
    {
        $name = DailyReward::where('id', $id);
        $name->delete();

        return [
            'status' => 'ok'
        ];
    }

    public function daily(PuzzlesRepository $repository)
    {
        return [
            'daily' => new DailyRewardDisplayResource($repository->getDailyQuote())
        ];
    }

    public function svadhyaya(PuzzlesRepository $repository)
    {
        return [
            'svadhyaya' => new DailyRewardsResource($repository->getSvadhyaya())
        ];
    }

    public function ownedQuotes(PuzzlesRepository $repository)
    {
        return [
            'owned_quotes' => DailyRewardDisplayResource::collection($repository->getUserQuotes())
        ];
    }

    public function ownedStories(PuzzlesRepository $repository)
    {
        return [
            'owned_stories' => DailyRewardDisplayResource::collection($repository->getUserStories())
        ];
    }
}
