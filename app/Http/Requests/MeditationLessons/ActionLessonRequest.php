<?php

namespace App\Http\Requests\MeditationLessons;

use Illuminate\Foundation\Http\FormRequest;

class ActionLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|int',
            'spiritual_name' => 'string|nullable',
            'notes' => 'string|nullable'
        ];
    }
}
