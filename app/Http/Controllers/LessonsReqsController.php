<?php

namespace App\Http\Controllers;

use App\LessonRequirement;
use Illuminate\Http\Request;

class LessonsReqsController extends Controller
{
    public function index() {
        $reqs = LessonRequirement::where('acarya_id', auth()->user()->id)->orderBy('lesson')->get();

        return [
            'reqs' => $reqs
        ];
    }

    public function store()
    {
        $reqs = request('reqs');

        foreach($reqs as $item) {
            if ($item['id'] !== null) {
                $name = LessonRequirement::where('id', $item['id']);
                $name->update($item);
            } else {
                $item['acarya_id'] = auth()->user()->id;
                LessonRequirement::create($item);
            }
        }

        return [
            'status' => 'ok'
        ];
    }
}
