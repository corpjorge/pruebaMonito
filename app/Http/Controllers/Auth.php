<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'document' => 'required|number',
        ]);

        $user = User::where('document', $request->document)->first();

        if (! $user ) {
            throw ValidationException::withMessages([
                'document' => ['Error de ingreso'],
            ]);
        }

        return $user->createToken($request->document)->plainTextToken;
    }

    public function user(Request $request)
    {
        return response()->json([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'document' => auth()->user()->document,
        ]);
    }

    public function temp(Request $request)
    {
        if (auth()->user()->id === 1){
            $participants = Participant::orderBy('id', 'desc')->limit(1000)->get()->load('user');

             foreach ($participants as $participant){
                 echo 'id:'.$participant->id.' / turn:'.$participant->turn.' win: '.$participant->winner.' / fecha: '.$participant->created_at;
                 echo '<br>';
             }
        }
    }


}
