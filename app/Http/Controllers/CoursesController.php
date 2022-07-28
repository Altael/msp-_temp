<?php

namespace App\Http\Controllers;

use App\Call;
use App\CallRequest;
use App\Course;
use App\Http\Resources\StagesResource;
use App\Http\Traits\HistoryTrait;
use App\Models\MeditationLessons\LessonsRequests;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    use HistoryTrait;

    public function startCourse()
    {
        $course_slug = request('course_slug');
        if(!$course_slug) return ['status' => 'You... probably did something wrong. Otherwords - gerrarahere, man;'];

        $course = Course::where('slug', $course_slug)->first();

        $user = auth()->user();

        $pivot_course = \DB::table('course_user')->where('course_id', $course->id)->where('user_id', $user->id)->first();

        if(!$pivot_course) {
            $course->users()->syncWithoutDetaching([$user->id]);
            $first_stage = $course->stages()->where('stages.order', 1)->first();
            $first_stage->users()->syncWithoutDetaching([$user->id]);

            $this->saveHistoryLog('course-open', $course);
            $this->saveHistoryLog('stage-open', $first_stage);
        }

        $stages = $course->stages;

        $course_data = [
            'finished' => $pivot_course ? $pivot_course->finished : false
        ];

        foreach ($stages as $index => $stage) {
            $course_data['stages_info'][$index] = [
                'finished' => false,
                'id' => $stage->id
            ];

            $pivot_stage = null;

            $pivot_stage = \DB::table('stage_user')
                ->where('stage_id', $stage->id)
                ->where('user_id', $user->id)->first();
            $course_data['stages'][$index] = new StagesResource($stage);
            $course_data['stages_info'][$index]['finished'] = $pivot_stage ? $pivot_stage->finished : false;
        }

        if($course_slug === 'about-spiritual-path') {
            $course_data['successfull_call'] = CallRequest::where('user_id', $user->id)->where('call_id', Call::where('slug', 'adequate-1')->first()->id)->where('closed', true)->exists();
            $course_data['open_request'] = CallRequest::where('user_id', $user->id)->where('call_id', Call::where('slug', 'adequate-1')->first()->id)->where('closed', false)->exists();
            $course_data['initiation_request'] = LessonsRequests::where('user_id', $user->id)->where('type', 'get')->where('lesson', 1)->exists();
        }

        return [
            'course' => $course_data
        ];
    }
}
