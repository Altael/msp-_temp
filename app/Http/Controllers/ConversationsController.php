<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions\Questions;

class ConversationsController extends Controller
{
    public function index()
    {
        $question = Questions::where('id', request('dialogue'))->first();

        return [
            'question' => $question
        ];
    }
}
