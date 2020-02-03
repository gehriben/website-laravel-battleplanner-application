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

    Route::prefix('/battleplan')->group(function () {
        Route::post('/', 'BattleplanController@create')->name("Battleplan.create");
        Route::get('/{battleplan}', 'BattleplanController@read')->name("Battleplan.read");
        Route::post('/{battleplan}', 'BattleplanController@update')->name("Battleplan.update");
        Route::delete('/{battleplan}', 'BattleplanController@delete')->name("Battleplan.delete");
        // Route::post('vote', 'BattleplanController@vote')->name("Battleplan.vote");
        // Route::post('copy', 'BattleplanController@copy')->name("Battleplan.copy");
    });

    Route::prefix('/draw')->group(function () {
        Route::post('/', 'DrawController@create')->name("Draw.create");
        Route::get('/{draw}', 'DrawController@read')->name("Draw.read");
        Route::post('/{draw}', 'DrawController@update')->name("Draw.update");
        Route::delete('/{draw}', 'DrawController@delete')->name("Draw.delete");
        // Route::post('vote', 'BattleplanController@vote')->name("Battleplan.vote");
        // Route::post('copy', 'BattleplanController@copy')->name("Battleplan.copy");
    });

});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
