<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Participant;
use App\Models\Winner;
use Illuminate\Http\Request;


class SlotsController extends Controller
{
    public function slots()
    {
        if (!auth()->user()->go){
            auth()->logout();
            return redirect('/');
        }

        auth()->user()->update([ 'go' => null ]);

        $exists = Winner::where('user_id', auth()->user()->id)->exists();

        if ($exists){
            return view('final');
        }

        $participant = new Participant;
        $participant->user_id = auth()->user()->id;
        $participant->save();

        $winner = Award::where('winner',$participant->id)->exists();

        $turn = $participant->id;

        if ($winner){
            $win = true;
            $img = 'win.png';
            $participant->winner = 1;
            $participant->save();
        } else {
            $img = 'lose.png';
            $win = false;
        }

        $option =  rand(1,10);
        $rand_one = '-'.rand(1,120120);
        $rand_two = '-'.rand(1,120120);
        $rand_three = '-'.rand(1,120120);

        if ($win){
            $option = 11;
        }

        if ($option == 1){
            $one = $rand_one;
            $two = -10220;
            $three = -16220;
        }

        if ($option == 2){
            $one = -16220;
            $two = $rand_two;
            $three = -19220;
        }

        if ($option == 3){
            $one = -15240;
            $two = $rand_two;
            $three = $rand_three;
        }

        if ($option == 4){
            $one = $rand_one;
            $two = $rand_two;
            $three = -30200;
        }

        if ($option == 5){
            $one = $rand_one;
            $two = -21220;
            $three = $rand_three;
        }

        if ($option == 6){
            $one = -21220;
            $two = $rand_three;
            $three = -16620;
        }

        if ($option == 7){
            $one = -11150;
            $two = -10120;
            $three = $rand_three;
        }

        if ($option == 8){
            $one = $rand_one;
            $two = -19920;
            $three = $rand_three;
        }

        if ($option == 9){
            $one = -15638;
            $two = $rand_two;
            $three = $rand_three;
        }

        if ($option == 10){
            $one = -11160;
            $two = -11215;
            $three = $rand_three;
        }

        if ($option == 11){
            $one = -16220;
            $two = -16220;
            $three = -16220;
        }

        return view('slots', compact('one', 'two', 'three', 'img', 'turn' ));
    }

    public function run(Request $request)
    {
        $participant = Participant::where('id', $request->he)->where('user_id', auth()->user()->id)->first();
        $participant->turn = 1;
        $participant->save();
    }

    public function verify(Request $request)
    {
        $participant = Participant::where('id', $request->he)->where('user_id', auth()->user()->id)->where('winner',1)->first();

        if ($participant){
            $winner = new Winner;
            $winner->user_id = auth()->user()->id;
            $winner->save();
        }

    }

    public function obtain(Request $request)
    {


    }

}
