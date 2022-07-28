<?php

namespace App\Http\Controllers;

use App\Program;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index()
    {
        return [
            'programs' => Program::orderByDesc('vip')->orderBy('order')->get()
        ];
    }

    public function save()
    {
        $program = request('program');

        if($item = Program::find($program['id'])) {
            $item->update($program);
        } else {
            Program::create($program);
        }

        return [
            'status' => 'ok'
        ];
    }
}
