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
//Route::resource('usuarios','UserController');
//Route::resource('personas','PersonaController');
//Route::resource('roles','RolController');

//Route::get('/','Auth\LoginController@login');
Route::get('/','UserController@index')->middleware('auth');
Route::get('/usuarios','UserController@index')->name('usuarios.index')->middleware('auth');
Route::get('/personas','PersonaController@index')->name('personas.index')->middleware('auth');
Route::get('/home','PersonaController@index')->name('personas.index')->middleware('auth');
Route::get('/roles','RolController@index')->name('roles.index')->middleware('auth');
Route::get('/install','UserController@install')->name('usuarios.install');

Route::post('/personas/destroy','PersonaController@destroy')->name('personas.destroy');
Route::post('/usuarios/destroy','UserController@destroy')->name('usuarios.destroy');
Route::post('/usuarios/store','UserController@store')->name('usuarios.store');
Route::post('/personas/store','PersonaController@store')->name('personas.store');
Route::post('/permisos/store','PermisoController@store')->name('permisos.store');
Route::post('/roles/store','PolController@store')->name('roles.store');
Route::post('/permisos/update','PermisoController@update')->name('permisos.update');
Route::post('/permisos/setupdate','PermisoController@setupdate')->name('permisos.setupdate');
Route::post('/permisos/destroy','PermisoController@destroy')->name('permisos.destroy');
Route::post('/roles/store','RolController@store')->name('roles.store');
Route::post('/usuarios/actualizar','UserController@actualizar')->name('usuarios.actualizar');
Route::post('/usuarios/editar','UserController@editar')->name('usuarios.editar');
Route::post('/personas/editar','PersonaController@editar')->name('personas.editar');
Route::post('/personas/actualizar','PersonaController@actualizar')->name('personas.actualizar');


//Route::post('/usuarios/editar',['uses'=>'UsuarioController@editar']);

//Route::resource('usuarios','UserController');

/*
Route::get('/', function () {
    return view('usuarios.login');
});
*/

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
