<?php

namespace App\Http\Controllers;

use App\Aharya;
use App\Asanas;
use App\DailyPractice;
use App\Dharmacakra;
use App\Fullbath;
use App\Halfbath;
use App\Pancajania;
use App\Upavasa;
use Illuminate\Http\Request;
use App\PracticeRank;
use App\PracticePoint;
use App\Http\Resources\DailyPracticeRanksResource;
use App\Http\Resources\DailyPracticePointsResource;
use App\Http\Resources\DailyPracticeResource;

class DailyPracticesEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $points = PracticePoint::all();
        $aharya = Aharya::all();
        $asanas = Asanas::all();
        $dharmacakra = Dharmacakra::all();
        $fullbath = Fullbath::all();
        $halfbath = Halfbath::all();
        $pancajania = Pancajania::all();
        $upavasa = Upavasa::all();
        return [
            'ranks' => DailyPracticeRanksResource::collection(PracticeRank::all()),
            'points' => $points,
            'aharya' => $aharya,
            'asanas' => $asanas,
            'dharmacakra' => $dharmacakra,
            'fullbath' => $fullbath,
            'halfbath' => $halfbath,
            'pancajania' => $pancajania,
            'upavasa' => $upavasa
        ];
    }

    public function store()
    {
        $practices = request('timePractices');
        foreach($practices as $item) {
            $practice = PracticePoint::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('aharya');
        foreach($practices as $item) {
            $practice = Aharya::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('asanas');
        foreach($practices as $item) {
            $practice = Asanas::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('dharmacakra');
        foreach($practices as $item) {
            $practice = Dharmacakra::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('fullbath');
        foreach($practices as $item) {
            $practice = Fullbath::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('halfbath');
        foreach($practices as $item) {
            $practice = Halfbath::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('pancajania');
        foreach($practices as $item) {
            $practice = Pancajania::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('upavasa');
        foreach($practices as $item) {
            $practice = Upavasa::where('id', $item['id']);
            $practice->update($item);
        }
        $practices = request('ranks');
        foreach($practices as $item) {
            if ($item['id'] !== null) {
                $practice = PracticeRank::where('id', $item['id']);
                $practice->update($item);
            } else {
                PracticeRank::create($item);
            }
        }

        return [
            'status' => 'ok'
        ];
    }
}
