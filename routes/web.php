<?php

use Illuminate\Support\Facades\Route;

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
Route::post('/usuarios/editar','UsuarioController@editar')->name('usuarios.editar');
Route::get('/usuarios/login','UsuarioController@login')->name('usuarios.login');
Route::get('/usuarios/index','UsuarioController@index')->name('usuarios.index');
//Route::post('/usuarios/editar',['uses'=>'UsuarioController@editar']);

Route::resource('usuarios','UsuarioController');
Route::get('/', function () {
    return view('usuarios.login');
});
