<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\materia;
use App\materia_curso;
use App\personal;
use App\programa_materia;
use App\horario_materia;
use App\materia_horario;
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

    public function listarAgregar(Request $request){
        
        if ($request->ajax()) { 
            $respuesta = $request->post();
            $materia_curso = materia::where('materias.curso_correspondiente', '=', $respuesta['nombre_curso'])->get();
            return Datatables::of($materia_curso)
                    ->addIndexColumn()
                    ->addColumn('seleccionar', function($row){

                           $btn = 'codigo del select';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }



    public function agregarMateriaCurso(Request $request){

       $respuesta = $request->post();
       for ($i = 0; $i < count($respuesta['materias']); $i++ ){
            $mat_cur = materia_curso::where('materia_cursos.id_curso', '=',$respuesta['id_curso'] )
                                      ->where('materia_cursos.id_materia' , '=', $respuesta['materias'][$i])->get();
                         
            if (!($mat_cur->isNotEmpty())){
                 $registro = ['id_curso'=>$respuesta['id_curso'], 'id_materia'=>$respuesta['materias'][$i]];
                 materia_curso::create($registro);
            }else {
                 return response()->json(['0'=>'ERROR! Una materia seleccionada ya se encuentra en el curso. Presione la tecla escape para salir.']);
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

    public function eliminarMateriaCurso(Request $request) {
        $respuesta = $request->post();

        $materia_curso = materia_curso::where('materia_cursos.id_materia' , '=' , $respuesta['id_materia'])
                                      ->where('materia_cursos.id_curso' , '=' , $respuesta['id_curso'])
                                      ->get();

        if ($materia_curso->isNotEmpty()){
            $materia_curso->delete();
            return response()->json([
                '0' => '500']);
        }else{
            return response()->json([
            '0' => 'error']);
        }
        

    }

    public function asignarHorarioMateria(Request $request){
        $respuesta = $request->post();

        $materia_curso = materia_curso::where('materia_cursos.id_materia' , '=' , $respuesta['id_materia'])
                                      ->where('materia_cursos.id_curso' , '=' , $respuesta['id_curso'])
                                      ->get();

        $horas_semanales = materia::select('materias.carga_horaria')
                                ->where('materias.id', '=' , $respuesta['id_materia'])
                                ->get();                            
                       
        $hs_acumuladas = 0;
        
        for ($i = 0; $i < count($respuesta['dias']); $i++){
            $inicio = (int)$respuesta['horas_fin'][$i];
            $fin = (int)$respuesta['horas_inicio'][$i];
            $hs_acumuladas += $inicio - $fin ;
        }    

        if ($hs_acumuladas > $horas_semanales[0]['carga_horaria']){
            return response()->json([
                '0' => 'ERROR! La cantidad de horas que intenta cargar es mayor a la carga horaria semanal.',
            ]);

        }else{

            for ($i = 0; $i < count($respuesta['dias']); $i++){
                
                if ($respuesta['horas_inicio'][$i] >= $respuesta['horas_fin'][$i]){
                    return response()->json([
                        '0' => 'ERROR! La hora de inicio debe ser anterior a la hora de fin.'
                    ]);
                } else{
                    //Se chequea si el horario ya existe, sino se lo crea
                    $horario_existente = horario_materia::where('horario_materias.dia_semana' , '=', $respuesta['dias'][$i])
                                                        ->where('horario_materias.hora_inicio', '=', $respuesta['horas_inicio'][$i])
                                                        ->where('horario_materias.hora_fin', '=', $respuesta['horas_fin'][$i])
                                                        ->get();
                    if($horario_existente->isNotEmpty()){
                        $id_horario = $horario_existente[0]['id'];
                    }else{
                        $registro = ['hora_inicio'=>$respuesta['horas_inicio'][$i],'hora_fin'=>$respuesta['horas_fin'][$i],'dia_semana'=>$respuesta['dias'][$i]];
                        $horarioCreate = horario_materia::create($registro);
                        $id_horario = $horarioCreate['id'];                
                    }  

                    $registro_materia_horario = ['id_horario'=>$id_horario,'id_materia_curso'=>$materia_curso[0]['id']];
                    materia_horario::create($registro_materia_horario);
                    
                    

                }
            }

        }

         return response()->json([
                    '0' => '500'
                ]);
    }

    public function controlarHorario(Request $request){
        $respuesta = $request->post();

        $materia_curso = materia_curso::where('materia_cursos.id_materia' , '=' , $respuesta['id_materia'])
                                      ->where('materia_cursos.id_curso' , '=' , $respuesta['id_curso'])
                                      ->get();

        $materia_horarios = materia_horario::where('materia_horarios.id_materia_curso', '=', $materia_curso[0]['id'])->get();

        if ($materia_horarios->isNotEmpty()){

            for ($i = 0; $i < count($materia_horarios); $i++){
                $horario_materia[$i] =  horario_materia::select('horario_materias.*')
                                                    ->where('horario_materias.id' , '=' , $materia_horarios[$i]['id_horario']) 
                                                    ->get();
            }


            return response()->json([
                '0' => '500',
                'id_materia' => $respuesta['id_materia'],
                'id_curso' => $respuesta['id_curso'],
                'horarios' => $horario_materia,
            ]);
        }else{
            return response()->json([
                '0' => '1',
                'id_materia' => $respuesta['id_materia'],
                'id_curso' => $respuesta['id_curso'],
            ]);


        }

    }    


    public function updateHorarioMateria(Request $request){
        $respuesta = $request->post();        

        $materia_curso = materia_curso::where('materia_cursos.id_materia' , '=' , $respuesta['id_materia'])
                                      ->where('materia_cursos.id_curso' , '=' , $respuesta['id_curso'])
                                      ->get();

        $materia_horarios = materia_horario::where('materia_horarios.id_materia_curso', '=', $materia_curso[0]['id'])->get();



        for ($i = 0; $i < count($materia_horarios); $i++){
                $materia_horarios[$i]->delete();
            
        }

        $horas_semanales = materia::select('materias.carga_horaria')
                                ->where('materias.id', '=' , $respuesta['id_materia'])
                                ->get();                            
                       
        $hs_acumuladas = 0;
        
        for ($i = 0; $i < count($respuesta['dias']); $i++){
            $inicio = (int)$respuesta['horas_fin'][$i];
            $fin = (int)$respuesta['horas_inicio'][$i];
            $hs_acumuladas += $inicio - $fin ;
        }    

        if ($hs_acumuladas > $horas_semanales[0]['carga_horaria']){
            return response()->json([
                '0' => 'ERROR! La cantidad de horas que intenta cargar es mayor a la carga horaria semanal.',
            ]);

        }else{
            for ($i = 0; $i < count($respuesta['dias']); $i++){
                
                if ($respuesta['horas_inicio'][$i] >= $respuesta['horas_fin'][$i]){
                    return response()->json([
                        '0' => 'ERROR! La hora de inicio debe ser anterior a la hora de fin.'
                    ]);
                } else{
                    //Se chequea si el horario ya existe, sino se lo crea
                    $horario_existente = horario_materia::where('horario_materias.dia_semana' , '=', $respuesta['dias'][$i])
                                                        ->where('horario_materias.hora_inicio', '=', $respuesta['horas_inicio'][$i])
                                                        ->where('horario_materias.hora_fin', '=', $respuesta['horas_fin'][$i])
                                                        ->get();
                    if($horario_existente->isNotEmpty()){
                        $id_horario = $horario_existente[0]['id'];
                    }else{
                        $registro = ['hora_inicio'=>$respuesta['horas_inicio'][$i],'hora_fin'=>$respuesta['horas_fin'][$i],'dia_semana'=>$respuesta['dias'][$i]];
                        $horarioCreate = horario_materia::create($registro);
                        $id_horario = $horarioCreate['id'];                
                    }  

                    $registro_materia_horario = ['id_horario'=>$id_horario,'id_materia_curso'=>$materia_curso[0]['id']];
                    materia_horario::create($registro_materia_horario);
                    
                }
            }
        }    
         return response()->json([
                    '0' => '500'
                ]); 

    }




}    