<?php

namespace App\Http\Controllers;

class UsefulMaterialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('materials.index');
    }
}