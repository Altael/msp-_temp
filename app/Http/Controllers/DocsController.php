<?php

namespace App\Http\Controllers;

use App\Models\Geolocation\Sector;
use File;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\User\User;

class DocsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function policy()
    {
        $lang = app()->getLocale();

        return view('docs.policy', compact('lang'));
    }

    public function terms()
    {
        $lang = app()->getLocale();

        return view('docs.terms', compact('lang'));
    }

    public function offer()
    {
        $lang = app()->getLocale();

        return view('docs.offer', compact('lang'));
    }

    public function newsletter()
    {
        $lang = app()->getLocale();

        return view('docs.newsletter', compact('lang'));
    }

    public function redirect()
    {
        return File::get(public_path() . '/docs/index.html');
    }
}
