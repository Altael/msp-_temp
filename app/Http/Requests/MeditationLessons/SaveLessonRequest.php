<?php

namespace App\Http\Requests\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveLessonRequest extends FormRequest
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
        $rules = [
            'lessons' => 'required|array|min:1',
            'lessons.*' => 'required|int|min:1|max:6',
            'type' => ['required', Rule::In(['check', 'get'])],
            'meditation_hours' => 'int',
        ];

        return $rules;
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (!$this->isLessonAvailableForUser($this->user()->getId())) {
                $validator->errors()->add('lessons', 'This lesson is unavailable');
            }
        });
    }

    /**
     * @param int $userId
     * @return int
     */
    private function isLessonAvailableForUser(int $userId): int
    {
        $max = app(MeditationLessonsServiceInterface::class)->getLastUserLesson($userId);
        if ($this->request->get('type') === 'get') {
            ++$max;
        }

        if (!is_array($this->request->get('lessons'))) {
            return false;
        }

        foreach ($this->request->get('lessons') as $lesson) {
            if ($lesson > $max) {
                return false;
            }
        }

        return true;
    }
}
