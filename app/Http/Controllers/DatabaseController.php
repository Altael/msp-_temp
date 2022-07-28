<?php

namespace App\Http\Controllers;

use App\Models\MeditationLessons\MeditationLessons;
use App\Models\User\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class DatabaseController extends Controller
{
    public function index() {
        /*DB::enableQueryLog();*/
        $data = MeditationLessons::where('lesson_number', 1)
            ->whereDate('receiving_date', '>', '2021.01.01')
            ->whereDate('receiving_date', '<', '2021.07.30')
            ->where('manual', false)
            ->with('user.districtArea.district.diocese')
            ->get();
        /*dd(DB::getQueryLog());*/

        return view('handbooks.databaseRequest', [
            'data' => $data
        ]);


    }
}
