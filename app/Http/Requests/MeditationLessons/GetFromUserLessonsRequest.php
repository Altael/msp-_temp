<?php

namespace App\Http\Requests\MeditationLessons;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetFromUserLessonsRequest extends FormRequest
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
            'phone' => 'string',
            'city' => 'string',
            'profession' => 'string',
            'userName' => 'string',
            'orderBy' => 'string',
            'orderType' => [Rule::In(['asc', 'desc'])],
            'skip' => 'int',
            'take' => 'int'
        ];
    }
}
