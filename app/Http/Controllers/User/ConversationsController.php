<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ConversationsController extends Controller
{
    public function index()
    {
        return view('user.conversations');
    }
}
