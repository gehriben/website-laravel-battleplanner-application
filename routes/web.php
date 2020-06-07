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

// Account
Route::prefix('/account')->group(function () {
  Route::get('/', 'AccountController@index')->name("Account.index");
});

Route::prefix('/vote')->group(function () {
    Route::post('/', 'VoteController@create')->name("Vote.index");
});

Route::prefix('/map')->group(function () {
    Route::get('/', 'MapController@index')->name("Map.index");
    Route::get('new', 'MapController@new')->name("Map.new");
    Route::get('{map}/edit', 'MapController@edit')->name("Map.edit");
    Route::get('{map}', 'MapController@show')->name("Map.show");

    // API's
    Route::post('{map}/delete', 'MapController@delete')->name("Map.delete");
    Route::post('/', 'MapController@create')->name("Map.create");
    Route::post('/{map}', 'MapController@update')->name("Map.update");
});

Route::prefix('/admin')->group(function () {
    Route::get('/', 'AdminController@index')->name("Admin.index");
});

Route::prefix('/operators')->group(function () {
    Route::get('/', 'OperatorController@index')->name("Operators.index");
    Route::get('new', 'OperatorController@new')->name("Operators.new");
    Route::get('{operator}', 'OperatorController@show')->name("Operators.show");
    Route::get('{operator}/edit', 'OperatorController@edit')->name("Operators.edit");

    // APIs
    Route::post('{operator}/delete', 'OperatorController@delete')->name("Operator.delete");
    Route::post('/', 'OperatorController@create')->name("Operators.create");
    Route::post('/{operator}', 'OperatorController@update')->name("Operators.update");
});

Route::prefix('/gadgets')->group(function() {
    Route::get('/', 'GadgetController@index')->name("Gadgets.index");
    Route::get('new', 'GadgetController@new')->name("Gadgets.new");
    Route::get('{gadget}', 'GadgetController@show')->name('Gadgets.show');
    Route::get('{gadget}/edit', 'GadgetController@edit')->name('Gadgets.edit');

    // APIs
    Route::post('{gadget}/delete', 'GadgetController@delete')->name("Gadget.delete");
    Route::post('/', 'GadgetController@create')->name("Gadgets.create");
    Route::post('/{gadget}', 'GadgetController@update')->name("Gadgets.update");
});

Route::prefix('/battleplan')->group(function () {
    Route::get('/', 'BattleplanController@index')->name("Battleplan.index");
    Route::get('new', 'BattleplanController@new')->name("Battleplan.new");
    Route::get('{battleplan}', 'BattleplanController@show')->name("Battleplan.show");
    Route::get('{battleplan}/edit', 'BattleplanController@editGenerateRoom')->name("Battleplan.editGenerateRoom");
    Route::get('{battleplan}/edit/{connection_string}', 'BattleplanController@edit')->name("Battleplan.edit");

    // API's
    Route::post('/', 'BattleplanController@create')->name("Battleplan.create");
    Route::post('{battleplan}', 'BattleplanController@update')->name("Battleplan.update");

});

Route::prefix('/lobby')->group(function () {
    Route::get('{connection_string}', 'LobbyController@show')->name("Lobby.show");
    Route::post('{connection_string}/request-battleplan', 'LobbyController@requestBattleplan')->name("Lobby.requestBattleplan");
    Route::post('{connection_string}/response-battleplan', 'LobbyController@responseBattleplan')->name("Lobby.responseBattleplan");
    Route::post('{connection_string}/request-draw-delete', 'LobbyController@requestDrawDelete')->name("Lobby.requestDrawDelete");
    Route::post('{connection_string}/request-draw-create', 'LobbyController@requestDrawCreate')->name("Lobby.requestDrawCreate");
    Route::post('{connection_string}/request-operator-slot-change', 'LobbyController@requestOperatorSlotChange')->name("Lobby.requestOperatorSlotChange");
    Route::post('{connection_string}/request-draw-update', 'LobbyController@requestDrawUpdate')->name("Lobby.requestDrawUpdate");
    Route::post('{connection_string}/connected', 'LobbyController@connected')->name("Lobby.connected");
    Route::post('{connection_string}/disconnected', 'LobbyController@disconnected')->name("Lobby.disconnected");
    Route::post('{connection_string}/request-reload', 'LobbyController@requestReload')->name("Lobby.requestReload"); 
});
