<?php

namespace App\Http\Requests\MeditationLessons;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAllLessonRequest extends FormRequest
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
            'lesson' => 'int',
            'userName' => 'string',
            'city' => 'string',
            'phone' => 'string',
            'type' => [Rule::In(['check', 'get'])],
            'status' => 'int',
            'orderBy' => 'string',
            'orderType' => [Rule::In(['asc', 'desc'])],
            'skip' => 'int',
            'take' => 'int'
        ];
    }
}
