<?php

namespace App\Http\Controllers;

use App\Http\Traits\HistoryTrait;
use App\Stage;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    use HistoryTrait;

    public function closeStage()
    {
        $stage_id = request('stage_id');
        if(!$stage_id) return ['status' => 'gerrarahere'];

        $user_id = auth()->user()->id;
        $stage = Stage::find($stage_id);

        $stage->users()->syncWithoutDetaching([$user_id => ['finished' => true]]);

        $this->saveHistoryLog('stage-finish', $stage);

        if($next_stage = $stage->course->stages()->where('order', $stage->order + 1)->first()) {
            $next_stage->users()->syncWithoutDetaching([$user_id]);

            $this->saveHistoryLog('stage-open', $next_stage);

            return [
                'status' => 'new stage unlocked'
            ];
        } else {
            $course = $stage->course;

            $course->users()->syncWithoutDetaching([$user_id => ['finished' => true]]);

            $this->saveHistoryLog('course-finish', $course);

            return [
                'status' => 'course finished'
            ];
        }
    }
}
