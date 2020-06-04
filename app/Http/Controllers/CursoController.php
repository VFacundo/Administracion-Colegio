<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ciclo_lectivo;
use App\curso;
use App\Persona;
use App\personal;
use App\alumno;
use App\alumno_curso;
use App\materia_curso;
use App\tipo_personals;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $cursos = curso::select('cursos.*')->where('cursos.id_ciclo_lectivo', '=', $id)->get();
        $ciclo = ciclo_lectivo::select('ciclo_lectivos.*')->where('ciclo_lectivos.id', '=', $id)->get();
        for ($i=0;$i< count($cursos); $i++){
            $cursos[$i]['materias_curso'] = curso::select('cursos.*','materias.*')
            ->join('materia_cursos', 'cursos.id', '=', 'materia_cursos.id_curso')
            ->join('materias', 'materia_cursos.id_materia' , '=', 'materias.id')
            ->where('cursos.id', '=', $cursos[$i]['id'] )->get();

            $cursos[$i]['alumnos_curso'] = alumno::select('alumnos.*','personas.legajo','personas.nombre_persona'
                                                            ,'personas.apellido_persona','personas.dni_persona', 'alumno_cursos.id_curso')
            ->join('alumno_cursos', 'alumno_cursos.id_alumno', '=', 'alumnos.id')
            ->join('personas', 'personas.id' , '=', 'alumnos.persona_asociada')
            ->where('alumno_cursos.id_curso', '=', $cursos[$i]['id'] )->get('alumnos.*','personas.*');

            $cursos[$i]['docentes_curso'] = $this->getPersonalCurso($cursos[$i]['id'] , 1);
            $cursos[$i]['preceptores_curso'] = $this->getPersonalCurso($cursos[$i]['id'] , 3);

          }

        return view('curso.index',compact('cursos'),compact('ciclo'));
        
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

    public function getPersonalCurso($id_curso, $id_tipo_personal) {
         return personal::select('personals.*','personas.*','personal_tipos.*')
            ->join('personal_tipos', 'personals.id', '=', 'personal_tipos.id_personal')
            ->join('personal_cursos', 'personals.id', '=', 'personal_cursos.id_personal')
            ->join('personas', 'personals.id_persona' , '=', 'personas.id')
            ->where('personal_tipos.id_tipo_personal', '=' , $id_tipo_personal)        
            ->where('personal_cursos.id_curso', '=', $id_curso)->get();
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

    public function agregarCursoCiclo(Request $request){
        $respuesta = $request->post();
        $curso_existente = curso::where('cursos.nombre_curso', '=', $respuesta['nombre_curso'])
                                ->where('cursos.anio', '=', $respuesta['anio'])
                                ->where('cursos.division', '=', $respuesta['division'])->get();

        if ($curso_existente->isNotEmpty()){
                    return response()->json([
                    '0' => 'El curso ya existe',
                    ]);
        }else{
                $cursoInsert = curso::create($respuesta);
                return response()->json([
                    '0' => '500',
                    '1' => $cursoInsert,   
                    ]);
        }                    
    }
}
