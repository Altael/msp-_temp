<?php

namespace App\Models\Questions;

use App\Models\BaseModel;

class Questions extends BaseModel
{
    protected $fillable = ['from_user_id', 'to_user_id', 'subject', 'status', 'last_message_date'];

    public function messages()
    {
        return $this->hasMany(QuestionMessages::class, 'question_id');
    }
}
