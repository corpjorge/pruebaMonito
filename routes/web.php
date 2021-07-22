<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SlotsController;
use App\Http\Controllers\WinnerController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth'], function () {
    Route::get('/me', [Auth::class, 'user']);
    Route::get('/questions', [QuestionController::class, 'questions']);
    Route::post('/finish', [QuestionController::class, 'finish']);
    Route::post('/run', [SlotsController::class, 'run']);
    Route::post('/verify', [SlotsController::class, 'verify']);
    Route::get('/close', [SlotsController::class, 'close']);
    Route::get('/congratulations', [SlotsController::class, 'congratulations']);
    Route::get('/niw', [SlotsController::class, 'close']);
    Route::get('/roulette', [WinnerController::class, 'data']);
    Route::get('/niw', [WinnerController::class, 'winners']);
    Route::get('/nrut', [WinnerController::class, 'turn']);
    Route::get('/pants', [WinnerController::class, 'participants']);
    Route::post('/set', [WinnerController::class, 'setTurn']);

    Route::get('/concurso', function () {  return view('welcome'); });
    Route::get('/slots', [SlotsController::class, 'slots']);

    Route::get('/temp', [Auth::class, 'temp']);

});

Route::get('/locked', [WinnerController::class, 'locked']);

Route::get('/', function () {  return redirect('/login'); });


