<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\alumno;
use App\alumno_curso;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listar(Request $request){
            $respuesta = $request->post();
            $alumnos = alumno::select('alumnos.*','personas.*')
                       ->join('personas', 'personas.id' , '=', 'alumnos.persona_asociada')
                       ->leftjoin('alumno_cursos', 'alumno_cursos.id_alumno' , '=', 'alumnos.id')
                       ->whereNull('alumno_cursos.id_alumno')
                       ->get();
            \Debugbar::info($alumnos);
            return response()->json(['alumnos'=>$alumnos]);
        }
    
}
