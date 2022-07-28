<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RequestsController extends Controller
{
    public function index()
    {
        return view('user.request');
    }
}
