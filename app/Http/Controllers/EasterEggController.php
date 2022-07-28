<?php

namespace App\Http\Controllers;

use App\EasterEggScore;
use Illuminate\Http\Request;

class EasterEggController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $scores = EasterEggScore::all();

        $userId = auth()->user()->id;
        $sent = EasterEggScore::where('user_id', $userId)
        ->get();

        return [
            'scores' => $scores,
            'sent' => count($sent) ? true : false
        ];
    }

    public function store()
    {
        $score = request('score');
        $score += ['user_id' => auth()->user()->id];

        EasterEggScore::create($score);

        return [
            'status' => 'ok',
        ];
    }
}
