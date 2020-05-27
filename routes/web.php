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
Route::get('/ciclo','CicloController@index')->name('ciclo.index');
Route::get('/curso/{id}','CursoController@index')->name('curso.index');



Route::post('/personas/destroy','PersonaController@destroy')->name('personas.destroy');
Route::post('/usuarios/destroy','UserController@destroy')->name('usuarios.destroy');
Route::post('/usuarios/store','UserController@store')->name('usuarios.store');
Route::post('/usuarios/update','UserController@update')->name('usuarios.update');
Route::post('/usuarios/refreshTable','UserController@refreshTable')->name('usuarios.refreshTable');
Route::post('/personas/store','PersonaController@store')->name('personas.store');
Route::post('/permisos/store','PermisoController@store')->name('permisos.store');
Route::post('/roles/store','RolController@store')->name('roles.store');
Route::post('/roles/update','RolController@update')->name('roles.update');
Route::post('/roles/destroy','RolController@destroy')->name('roles.destroy');
Route::post('/roles/setupdate','RolController@setupdate')->name('roles.setupdate');
Route::post('/permisos/update','PermisoController@update')->name('permisos.update');
Route::post('/permisos/setupdate','PermisoController@setupdate')->name('permisos.setupdate');
Route::post('/permisos/destroy','PermisoController@destroy')->name('permisos.destroy');
Route::post('/usuarios/actualizar','UserController@actualizar')->name('usuarios.actualizar');
Route::post('/usuarios/editar','UserController@editar')->name('usuarios.editar');
Route::post('/personas/editar','PersonaController@editar')->name('personas.editar');
Route::post('/personas/actualizar','PersonaController@actualizar')->name('personas.actualizar');
Route::post('/ciclo/store','CicloController@store')->name('ciclo.store');
Route::post('/ciclo/actualizar','CicloController@actualizar')->name('ciclo.actualizar');
Route::post('/ciclo/editar','CicloController@editar')->name('ciclo.editar');
Route::post('/materia/listar','MateriaController@listar')->name('materia.listar');
Route::post('/materia/agregarMateriaCurso','MateriaController@agregarMateriaCurso')->name('materia.agregarMateriaCurso');
Route::post('/alumno/listar','AlumnoController@listar')->name('alumno.listar');



//Route::post('/usuarios/editar',['uses'=>'UsuarioController@editar']);

//Route::resource('usuarios','UserController');

/*
Route::get('/', function () {
    return view('usuarios.login');
});
*/

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
