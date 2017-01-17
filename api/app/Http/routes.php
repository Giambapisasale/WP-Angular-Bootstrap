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

Route::get('downloadbakdb','BackupDownloadController@show');
Route::post('downloadbakdb','BackupDownloadController@store');

Route::post('istanza','IstanzeController@store');
Route::get('istanzaget','IstanzeController@store');

//Route::resource('acquedotto', 'AcquedottoController@store');
Route::post('acquedotto','AcquedottoController@store');

Route::resource('admin','AdminController');
Route::group(array('prefix'=>'admin'),function(){
	Route::get('admin/{id}',array('uses'=>'AdminController@show'));
});
Route::get('admin-import/{id}',array('uses'=>'AdminController@import'));



Route::resource('contratto', 'ContrattoController');

Route::group(array('prefix'=>'contratto'),function(){
	Route::get('dettaglio/{contratto}',array('uses'=>'ContrattoController@dettaglio'));
});


Route::resource('pubblicita', 'PubblicitaController');

Route::group(array('prefix'=>'pubblicita'),function(){
	Route::get('dettaglio/{id}',array('uses'=>'PubblicitaController@dettaglio'));
});

// Route::resource('pubblicita', 'PubblicitaController');

// Route::group(array('prefix'=>'pubblicita'),function(){
// 	Route::get('dettaglio/{id}',array('uses'=>'PubblicitaController@dettaglio'));
// });

Route::resource('affissioni', 'AffissioniController');

Route::group(array('prefix'=>'affissioni'),function(){
	Route::get('dettaglio/{id}',array('uses'=>'AffissioniController@dettaglio'));
});

Route::resource('verifica', 'VerificaController');

Route::group(array('prefix'=>'verifica'),function(){
    Route::get('dettaglio/{id}',array('uses'=>'VerificaController@dettaglio'));
	Route::get('accetta/{id}',array('uses'=>'VerificaController@accetta'));
	Route::get('rifiuta/{id}',array('uses'=>'VerificaController@rifiuta'));
});

Route::resource('utenti-verifica', 'VerificaController@utenti');

Route::group(array('prefix'=>'utenti-verifica'),function(){
	Route::get('utente/{id}',array('uses'=>'VerificaController@utente'));
	Route::get('accetta/{id}',array('uses'=>'VerificaController@accettaUtente'));
	Route::get('rifiuta/{id}',array('uses'=>'VerificaController@rifiutaUtente'));
});

Route::post('registrazione','RegistrazioneController@store');
Route::resource('registrazione', 'RegistrazioneController@store');




