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
Route::get('/install','UserController@install')->name('usuarios.install');
Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:admin'],'auth'], function(){
  Route::get('/usuarios','UserController@index')->name('usuarios.index')->middleware('auth');
  Route::get('/personas','PersonaController@index')->name('personas.index')->middleware('auth');
  Route::get('/home','PersonaController@index')->name('personas.index')->middleware('auth');
  Route::get('/roles','RolController@index')->name('roles.index')->middleware('auth');
  Route::get('/ciclo','CicloController@index')->name('ciclo.index');
  Route::get('/curso/{id}','CursoController@index')->name('curso.index');
  Route::get('/materias','MateriaController@index')->name('materia.index');
  Route::get('/alumnos','AlumnoController@index')->name('alumno.index');
  Route::get('/personal','PersonalController@index')->name('personal.index');


});



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
Route::post('/ciclo/destroy','CicloController@destroy')->name('ciclo.destroy');
Route::post('/ciclo/restaurarCiclo','CicloController@restaurarCiclo')->name('ciclo.restaurarCiclo');
Route::post('/materia/listar','MateriaController@listar')->name('materia.listar');
Route::post('/materia/agregarMateriaCurso','MateriaController@agregarMateriaCurso')->name('materia.agregarMateriaCurso');
Route::post('/alumno/listar','AlumnoController@listar')->name('alumno.listar');
Route::post('/alumno/agregarAlumnoCurso','AlumnoController@agregarAlumnoCurso')->name('alumno.agregarAlumnoCurso');
Route::post('/alumno/editar','AlumnoController@editar')->name('alumno.editar');
Route::post('/alumno/destroy','AlumnoController@destroy')->name('alumno.destroy');
Route::post('/curso/agregarCursoCiclo','CursoController@agregarCursoCiclo')->name('alumno.agregarCursoCiclo');
Route::post('/materia/store','MateriaController@store')->name('materia.store');
Route::post('/materia/destroy','MateriaController@destroy')->name('materia.destroy');
Route::post('/materia/editar','MateriaController@editar')->name('materia.editar');
Route::post('/materia/restaurarMateria','MateriaController@restaurarMateria')->name('materia.restaurarMateria');
Route::post('/materia/actualizar','MateriaController@actualizar')->name('materia.actualizar');
Route::post('/alumno/store','AlumnoController@store')->name('alumno.store');
Route::post('/alumno/listar_alumnos_personal','AlumnoController@listar_alumnos_personal')->name('alumno.listar_alumnos_personal');
Route::post('/alumno/actualizar','AlumnoController@actualizar')->name('alumno.actualizar');
Route::post('/alumno/eliminarAlumnoCurso','AlumnoController@eliminarAlumnoCurso')->name('alumno.eliminarAlumnoCurso');
Route::post('/alumno/restaurarAlumno','AlumnoController@restaurarAlumno')->name('alumno.restaurarAlumno');
Route::post('/personal/store','PersonalController@store')->name('personal.store');
Route::post('/personal/listar_personal','PersonalController@listar_personal')->name('alumno.listar_personal');
Route::post('/personal/actualizar','PersonalController@actualizar')->name('personal.actualizar');
Route::post('/personal/editar','PersonalController@editar')->name('personal.editar');
Route::post('/personal/destroy','PersonalController@destroy')->name('personal.destroy');
Route::post('/personal/restaurarPersonal','PersonalController@restaurarPersonal')->name('personal.restaurarPersonal');


Auth::routes();
