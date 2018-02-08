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
Route::resource('artefacto/artefacto', 'InventarioController');
Route::resource('movimiento/ingreso', 'IngresoController');
Route::resource('movimiento/egreso', 'EgresoController');
Route::get('/buscarEgreso','IngresoController@buscarEgreso');
Route::resource('artefacto/categoria', 'CategoriaController');
Route::resource('seguridad/usuario', 'UsuarioController');


Route::get('error', function(){ 
    abort(500);
});