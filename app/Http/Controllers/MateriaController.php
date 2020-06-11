<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\materia;
use App\materia_curso;
use App\personal;
use App\programa_materia;
use Illuminate\Support\Facades\Validator;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = materia::whereNull('materias.fecha_baja')->get();
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
        $respuesta = $request->post();

        $materia_existente = materia::where('materias.nombre', '=', $respuesta['nombre'])
                            ->where('materias.curso_correspondiente', '=', $respuesta['curso_correspondiente'])->get();
        $materia_baja = materia::select('materias.*')
                                     ->where('materias.fecha_baja', "<>", null)
                                     ->get();


        $validator = Validator::make($respuesta,[
            'nombre' => 'required|min:3|max:255|',
            'carga_horaria' => 'required|max:2',
        ]);

        if ($materia_existente->isNotEmpty() && $materia_baja->isNotEmpty() ){
            return response()->json([
                '0' => '1',
                '1' => $materia_existente,
            ]);
        }elseif ($materia_existente->isNotEmpty()) {
            return response()->json([
                '0' => 'La materia ya existe para este curso',
                ]);     
        }else { 
            if($validator->fails()){
                $errors = $validator->errors();
                foreach($errors->all() as $message){
                    $arrayErrores[] = $message;
                }
                return response()->json([
                    '0' => ($arrayErrores),
                    ]);
            }else{
                $materiaInsert = materia::create($respuesta);
                return response()->json([
                    '0' => '500',
                    '1' => $materiaInsert->id,
                    '2' => $materiaInsert->estado_materia,]);
            }
        }                        
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
        $materia_curso = materia::where('materias.curso_correspondiente', '=', $respuesta['nombre_curso'])->get();
        return response()->json(['materia_curso'=>$materia_curso]);
    }

    public function agregarMateriaCurso(Request $request){

        $respuesta = $request->post();
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

    public function destroy(Request $request)
    {
        $respuesta = $request->post();
        $materia = materia::findOrFail($respuesta['id_materia']);

        try{
          materia::whereId($respuesta['id_materia'])->update(['fecha_baja' => '2013-01-01 08:00:00']);
          return response()->json([
              '0' => '500']);
        } catch (\Exception $e) {
          return response()->json([
              '0' => 'error']);
        }
    }

    
    public function editar(Request $Request) {
        $respuesta = $Request->post();
        $materia = materia::findOrFail($respuesta['id']);
        
        return response()->json([
           'id' => $materia['id'],
           'nombre' => $materia['nombre'],
           'programa_materia' => $materia['programa_materia'],
           'carga_horaria' => $materia['carga_horaria'],
           'estado_materia' => $materia['estado_materia'],
           'curso_correspondiente' => $materia['curso_correspondiente'],
        ]);
    }

    public function restaurarMateria(Request $request){
        $respuesta = $request->post();
        materia::whereId($respuesta['id_materia'])->update(['fecha_baja' => null]);
        $materia = materia::findOrFail($respuesta['id_materia']);
        return response()->json([
            '0' => '500',
            '1' => $materia,
            ]);
    }

    public function actualizar(Request $request) {
        $respuesta = $request->post();
         $validator = Validator::make($respuesta,[
            'nombre' => 'required|min:3|max:255|',
            'carga_horaria' => 'required|max:2',
        ]);


        $materia_enCurso = materia_curso::select('materias.*')
                                     ->join('materias', 'materia_cursos.id_materia' , '=', 'materias.id')
                                     ->join('cursos', 'cursos.id', '=', 'materia_cursos.id_curso')
                                     ->join('ciclo_lectivos', 'ciclo_lectivos.id', '=', 'cursos.id_ciclo_lectivo')
                                     ->where('ciclo_lectivos.anio', '=', now())
                                     ->where('materias.nombre', '=', $respuesta['nombre'])
                                     ->where('materias.curso_correspondiente', '=', $respuesta['curso_correspondiente']) 
                                     ->get();

        $materia_existente = materia::where('materias.nombre', '=', $respuesta['nombre'])
                            ->where('materias.curso_correspondiente', '=', $respuesta['curso_correspondiente'])
                            ->get();

        $materia_datos = materia::where('materias.nombre', '=', $respuesta['nombre'])
                         ->where('materias.curso_correspondiente', '=', $respuesta['curso_correspondiente'])
                         ->where('materias.carga_horaria', '=', $respuesta['carga_horaria'])
                         ->where('materias.programa_materia', '=', $respuesta['programa_materia'])
                         ->where('materias.estado_materia', '=', $respuesta['estado_materia'])
                         ->get();

        if($materia_enCurso->isNotEmpty()){
            return response()->json([
                        '0'=>'La materia no puede ser editada porque esta asociada al ciclo lectivo actual',
                    ]);
        }else{
            if($validator->fails()){
                $errors = $validator->errors();
                foreach($errors->all() as $message){
                    $arrayErrores[] = $message;
                }
                return json_encode($arrayErrores);
            }else{
                if ($materia_existente->isNotEmpty()){
                    if ($materia_datos->isNotEmpty()){
                        return response()->json([
                            '0'=>'La materia ya existe',
                        ]);
                    }else{
                         materia::whereId($respuesta['id'])->update($respuesta);
                        return response()->json([
                        '0'=>'500',
                        '1'=> $respuesta['id'],
                        ]);
                    }
                }else{
                    materia::whereId($respuesta['id'])->update($respuesta);
                        return response()->json([
                        '0'=>'500',
                        '1'=> $respuesta['id'],
                        '2'=> $respuesta['estado_materia'],
                        ]);          
                }
            }    
        }                 

    }
}    