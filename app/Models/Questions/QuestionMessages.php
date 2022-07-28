<?php

namespace App\Models\Questions;

use App\Models\BaseModel;

class QuestionMessages extends BaseModel
{
    protected $fillable = ['question_id', 'user_id', 'text', 'status', 'date'];
}

