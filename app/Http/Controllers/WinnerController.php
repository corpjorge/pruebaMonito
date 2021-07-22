<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Participant;
use App\Models\Winner;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function data()
    {
        if (auth()->user()->id === 1){
            return view('data');
        }

        abort(404);

    }

    public function winners()
    {
        if (auth()->user()->id === 1){
            return Winner::all()->load('user');
        }

        abort(404);
    }

    public function turn()
    {
        if (auth()->user()->id === 1){
            return Award::find(1);
        }

        abort(404);
    }

    public function participants()
    {
        if (auth()->user()->id === 1){
            return Participant::orderBy('id', 'desc')->limit(1000)->get()->load('user');
        }

        abort(404);
    }

    public function setTurn(Request $request)
    {
        if (auth()->user()->id === 1){
            $award = Award::find(1);
            $award->winner = $request->wn;
            return $award->save();
        }

        abort(404);
    }

    public function locked()
    {
        return view('locked');
    }


}
