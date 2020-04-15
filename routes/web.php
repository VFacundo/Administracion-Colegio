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
Route::post('/usuarios/destroy','UserController@destroy')->name('usuarios.destroy');
Route::post('/usuarios/store','UserController@store')->name('usuarios.store');
Route::post('/usuarios/actualizar','UserController@actualizar')->name('usuarios.actualizar');
Route::post('/usuarios/editar','UserController@editar')->name('usuarios.editar');
//Route::get('/usuarios/login','UserController@login')->name('usuarios.login');
Route::get('/usuarios','UserController@index')->name('usuarios.index')->middleware('auth');
//Route::post('/usuarios/editar',['uses'=>'UsuarioController@editar']);

//Route::resource('usuarios','UserController');
Route::get('/','Auth\LoginController@login');
/*
Route::get('/', function () {
    return view('usuarios.login');
});
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
