<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// All authentication routes
Auth::routes();

// Landing page
Route::get('/', function(){
    return View("index.index");
})->name("index");


Route::prefix('/battleplan')->group(function () {
    Route::get('/', 'BattleplanController@index')->name("Battleplan.index");
    Route::get('/{battleplan/{battleplan}', 'BattleplanController@show')->name("Battleplan.show");
});

Route::prefix('/room')->group(function () {
    Route::get('/', 'RoomController@index')->name("Room.index");
    Route::get('/create', 'RoomController@create')->name("Room.create");
    Route::get('/{conn_string}', 'RoomController@show')->name("Room.show");
    Route::get('/{conn_string}/getBattleplan', 'RoomController@getBattleplan')->name("Room.getBattleplan");
});
