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

Route::get('/', function () {
    return view('auth/login');
});


Route::auth();
Route::resource('articulo/articulo', 'InventarioController');
Route::get('movimiento/ingreso', 'MovimientoController@index');
Route::get('articulo/articulo', 'InventarioController@index');
Route::resource('pdf','PdfController'); 
Route::get('tarea/tarea', 'TareaController@index');
Route::get('tarea/cargar', 'CargarlistaController@edit');
Route::get('usuario/{id}','UsuarioController@update');

Route::get('error', function(){ 
    abort(500);
});


Route::get('/home', 'HomeController@index');
