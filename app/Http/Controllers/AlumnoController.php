<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\alumno;
use App\alumno_curso;
use App\Persona;

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


    public function listar(Request $request){
        $respuesta = $request->post();
        $alumnos = Persona::select('personas.*','alumnos.*')
                   ->join('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                   ->leftjoin('alumno_cursos', 'alumno_cursos.id_alumno' , '=', 'alumnos.id')
                   ->whereNull('alumno_cursos.id_alumno')
                   ->get();
        return response()->json(['alumnos'=>$alumnos]);

    }

    public function agregarAlumnoCurso(Request $request){

        $respuesta = $request->post();
        $alum_cur = alumno_curso::where('alumno_cursos.id_curso', '=', $respuesta['id_curso'] )
                                      ->where('alumno_cursos.id_alumno' , '=', $respuesta['id_alumno'])->get();
        if (!($alum_cur->isNotEmpty())){
            $registro = ['id_alumno'=>$respuesta['id_alumno'], 'id_curso'=>$respuesta['id_curso']];
            alumno_curso::create($registro);
        }
        return response()->json(['0'=>'500']);
    }


    public function editar(Request $Request)
     {
         $respuesta = $Request->post();
         $alumno = alumno::findOrFail($respuesta['id']);
         //var_dump($_POST);
     return response()->json([
       'id' => $alumno['id'],
       'legajo_alumno' => $alumno['legajo_alumno'],
       'persona_asociada' => $alumno['persona_asociada'],
       'id_calendario' => $alumno['id_calendario'],
       'persona_tutor' => $alumno['tutor'],

        ]);
     }

    public function destroy(Request $request)
    {
        $respuesta = $request->post();

        $alumno_curso = alumno_curso::where('alumno_cursos.id_alumno' , '=' , $respuesta['id_alumno'])
                                      ->where('alumno_cursos.id_curso' , '=' , $respuesta['id_curso'])
                                      ->get()
                                      ->first();


        try{
        $alumno_curso->delete();
        return response()->json([
            '0' => '500']);
            }catch(\Exception $e){
        return response()->json([
            '0' => 'error']);
      }


    }


}
