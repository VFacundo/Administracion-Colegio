<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\materia;
use App\materia_curso;
use App\personal;
use App\programa_materia;
class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = materia::all();
        $programas = programa_materia::all();
        $personal = personal::select('personals.*','personas.nombre_persona','personas.apellido_persona')
                            ->join('personas', 'personas.id', '=' ,'personals.id_persona')->get();
        return view('materias.index',compact(['materias','personal','programas']));
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
        \Debugbar::info('store');
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
        $materia_curso = materia::where('materias.curso_correspondiente', '=', $respuesta['nombre_curso'])->get();
        \Debugbar::info($materia_curso);
        return response()->json(['materia_curso'=>$materia_curso]);
    }

    public function agregarMateriaCurso(Request $request){

        $respuesta = $request->post();
        \Debugbar::info($respuesta);
        for ($i = 0; $i < count($respuesta['materias']); $i++ ){
            $mat_cur = materia_curso::where('materia_cursos.id_curso', '=',$respuesta['id_curso'] )
                                      ->where('materia_cursos.id_materia' , '=', $respuesta['materias'][$i])->get();
            if (!($mat_cur->isNotEmpty())){
                 $registro = ['id_curso'=>$respuesta['id_curso'], 'id_materia'=>$respuesta['materias'][$i], 'horario_materia'=> '13'];
                 materia_curso::create($registro);    
            }                           
            
        }
        return response()->json(['0'=>'500']);
    }
}
