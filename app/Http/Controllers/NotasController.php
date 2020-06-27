<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\alumno;
use App\alumno_curso;

class NotasController extends Controller
{
    public function index($curso,$materia){

      $alumnos = alumno_curso::select('alumno_cursos.id_alumno','personas.nombre_persona','personas.apellido_persona')
                ->join('alumnos','alumno_cursos.id_alumno','=','alumnos.id')
                ->join('personas','alumnos.persona_asociada','=','personas.id')
                ->where('alumno_cursos.id_curso','=',$curso)->get();

      return view('notas.index',compact('alumnos'));
    }
}
