<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function questions(Question $questions)
    {
       return $questions::all(['id', 'title', 'choices'])->random(3);
    }

    public function finish(Request $request, Question $questions)
    {
        if (!$request->question_0){ return response()->json([ 'R' => false ]); }
        if (!$request->question_1){ return response()->json([ 'R' => false ]); }
        if (!$request->question_2){ return response()->json([ 'R' => false ]); }

        $question_0 = $questions->where('answer', $request->question_0)->exists();

        if (!$question_0){ return response()->json([ 'R' => false ]); }

        $question_1 = $questions->where('answer', $request->question_1)->exists();
        if (!$question_1){ return response()->json([ 'R' => false ]); }

        $question_2 = $questions->where('answer', $request->question_2)->exists();
        if (!$question_2){ return response()->json([ 'R' => false ]); }

        auth()->user()->update([ 'go' => 1 ]);

        return response()->json([ 'R' => true ]);

    }
}
