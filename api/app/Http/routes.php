<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::resource('acquedotto', 'AcquedottoController');

Route::resource('contratto', 'ContrattoController');

Route::group(array('prefix'=>'contratto'),function(){
	Route::get('dettaglio/{contratto}',array('uses'=>'ContrattoController@dettaglio'));
});

Route::group(array('prefix'=>'letture'),function(){
	Route::post('insert',array('uses'=>'ContrattoController@store'));
});