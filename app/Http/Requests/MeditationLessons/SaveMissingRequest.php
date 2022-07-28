<?php

namespace App\Http\Requests\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveMissingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isRegistrationCompleted() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $had_lessons = $this->request->get('hadLessons');
        $want_lessons = $this->request->get('lessons');

        $rules = [];

        if(in_array(1, $want_lessons) && !in_array(1, $had_lessons)) {
            if($this->request->get('acarya_first')['id'] === null) {
                $rules += [
                    'acarya_first_missing' => 'required',
                ];
            } else {
                $rules += [
                    'acarya_first.id' => 'required|gt:0',
                ];
            }
        }

        if(($this->request->get('acarya_changed') || in_array(1, $had_lessons)) && in_array(1, $want_lessons)) {
            if($this->request->get('acarya_now')['id'] === null) {
                $rules += [
                    'acarya_missing' => 'required',
                ];
            } else {
                $rules += [
                    'acarya_now.id' => 'required|gt:0',
                ];
            }
        }

        $rules += [
            'initiation_date' => 'nullable|date',
        ];

        return $rules;
    }
}
