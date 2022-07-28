<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserProfilesService;

class HomeController extends Controller
{
    public function index()
    {
        if (request()->root() === env('AM_URL')) {
            return redirect('/news');
        }

        return view('user.home');
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function diary()
    {
        return view('diary.index');
    }

    public function materials()
    {
        return view('materials.index');
    }
}
