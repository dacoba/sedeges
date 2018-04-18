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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/usuario', 'UsuarioController');
Route::resource('/centro', 'CentroController');
Route::resource('/infante', 'InfanteController');
Route::resource('/adoptante', 'AdoptanteController');
Route::resource('/solicitud', 'SolicitudAdopcionController');
Route::resource('/document', 'AdopcionDocumentController');

Route::get('/document/download/{id}', 'AdopcionDocumentController@download');

Route::get('adoptantes-json',array('as'=>'adoptantes.json','uses'=>'UsuarioController@user_adoptantes'));
Route::get('infantes-json',array('as'=>'infantes.json','uses'=>'InfanteController@json_infantes'));