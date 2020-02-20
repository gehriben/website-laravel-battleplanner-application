<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::prefix('battleplan')->group(function () {
        Route::post('/', 'BattleplanController@create')->name("Battleplan.create");
        Route::get('/{battleplan}', 'BattleplanController@read')->name("Battleplan.read");
        Route::post('/{battleplan}', 'BattleplanController@update')->name("Battleplan.update");
        Route::delete('/{battleplan}', 'BattleplanController@delete')->name("Battleplan.delete");
        Route::post('/{battleplan}/copy', 'BattleplanController@copy')->name("Battleplan.copy");
    });

    Route::prefix('draw')->group(function () {
        Route::post('/', 'DrawController@create')->name("Draw.create");
        Route::get('/{draw}', 'DrawController@read')->name("Draw.read");
        Route::post('/{draw}', 'DrawController@update')->name("Draw.update");
        Route::delete('/{draw}', 'DrawController@delete')->name("Draw.delete.single");
        Route::delete('/', 'DrawController@batchDelete')->name("Draw.delete.batch");
    });
    
    Route::prefix('vote')->group(function () {
        Route::post('/', 'VoteController@create')->name("Vote.create");
        Route::get('/{vote}', 'VoteController@read')->name("Vote.read");
        Route::post('/{vote}', 'VoteController@update')->name("Vote.update");
        Route::delete('/{vote}', 'VoteController@delete')->name("Vote.delete");
    });

    Route::prefix('room')->group(function () {
        Route::post('/', 'RoomController@create')->name("Room.create");
        Route::post('/{room}', 'RoomController@update')->name("Room.update");
    });
    
    Route::prefix('/operator-slot')->group(function () {
        Route::post('/{operatorSlot}', 'OperatorSlotController@update')->name("OperatorSlot.update");
    });

});

