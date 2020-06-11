<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\alumno;
use App\alumno_curso;
use App\Persona;
use App\responsable;
use Illuminate\Support\Facades\Validator;


class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos = alumno::whereNull('alumnos.fecha_baja')->get();

        for($i=0;$i<sizeof($alumnos);$i++){
          $Persona = Persona::findOrFail($alumnos[$i]['persona_asociada']);
          $alumnos[$i]['nombrePersona'] = $Persona['nombre_persona'];
          $alumnos[$i]['apellidoPersona'] = $Persona['apellido_persona'];
        }

        for($i=0;$i<sizeof($alumnos);$i++){
            $responsable = responsable::findOrFail($alumnos[$i]['persona_tutor']);
            $persona_tutor = Persona::findOrFail($responsable['persona_asociada']);
            $alumnos[$i]['persona'] = $persona_tutor['nombre_persona'] . ' ' . $persona_tutor['apellido_persona'];
            $alumnos[$i]['personaString'] = "Domicilio: " . $persona_tutor['domicilio'] . "<br>" . "Tel.: " . $persona_tutor['numero_telefono'];
         
        }

        $personas_tutor = Persona::select('personas.*')
                ->leftjoin('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                ->whereNull('alumnos.persona_asociada')
                ->get();

        return view('alumnos.index',compact('alumnos'),compact('personas_tutor'));
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
    public function store(Request $request) {
        $respuesta = $request->post();

        $validator = Validator::make($respuesta,[
            'legajo_alumno' => 'required|min:6|max:6|',
        ]);


        $alumno_existente = alumno::where('alumnos.legajo_alumno','=',$respuesta['legajo_alumno'])->get();
        $alumno_baja = alumno::select('alumnos.*')
                                     ->where('alumnos.fecha_baja', "<>", null)
                                     ->where('alumnos.legajo_alumno','=',$respuesta['legajo_alumno'])
                                     ->get();

        if($validator->fails()){
            $errors = $validator->errors();
                foreach($errors->all() as $message){
                    $arrayErrores[] = $message;
                }
            return response()->json([
                '0' => ($arrayErrores),
            ]);
        }elseif ($respuesta['persona_asociada'] == $respuesta['persona_tutor']) {
            return response()->json([
                '0' => 'Error! El alumno y su responsable no pueden ser la misma persona.',
            ]);
        }else{
            if($alumno_existente->isNotEmpty() && $alumno_baja->isNotEmpty()){
                return response()->json([
                    '0' =>'1',
                    '1' => $alumno_existente,
                ]);
            }elseif ($alumno_existente->isNotEmpty()) {
                        return response()->json([
                            '0' => 'El numero de legajo ya existe',
                        ]);         
            }else{
                $datos_responsable['persona_asociada'] = $respuesta['persona_tutor'];
                $responsableInsert = responsable::create($datos_responsable);
                $respuesta['persona_tutor'] = $responsableInsert->id;                
                $alumnoInsert = alumno::create($respuesta);
                $persona_asociada = Persona::findOrFail($alumnoInsert->persona_asociada);
                $persona_tutor = Persona::findOrFail($responsableInsert->persona_asociada);
                return response()->json([  
                    '0' => '500',
                    '1' => $alumnoInsert->id,
                    '2' => $persona_asociada,
                    '3' => $persona_tutor,
                ]);
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

    public function listar_alumnos_personal(Request $request){

        $personas_alumno = Persona::select('personas.*')
                   ->leftjoin('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                   ->leftjoin('personals', 'personas.id' , '=', 'personals.id_persona')
                   ->leftjoin('responsables', 'personas.id', '=', 'responsables.persona_asociada')
                   ->whereNull('responsables.persona_asociada')
                   ->whereNull('alumnos.persona_asociada')
                   ->whereNull('personals.id_persona')
                   ->get();

        $personas_tutor = Persona::select('personas.*')
                   ->leftjoin('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                   ->whereNull('alumnos.persona_asociada')
                   ->get();
           
        return response()->json(['persona_alumno'=>$personas_alumno , 'persona_tutor'=>$personas_tutor]);       
    } 

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
         $persona_asociada = Persona::findOrFail($alumno->persona_asociada);
         $responsable = responsable::findOrFail($alumno['persona_tutor']);
         $persona_tutor = Persona::findOrFail($responsable['persona_asociada']);
         //var_dump($_POST);
        return response()->json([
           'id' => $alumno['id'],
           'legajo_alumno' => $alumno['legajo_alumno'],
           'persona_asociada' => $alumno['persona_asociada'],
           'id_calendario' => $alumno['id_calendario'],
           'persona_tutor' => $persona_tutor['id'],
           'nombre_alumno' => $persona_asociada['nombre_persona'],
           'apellido_alumno' => $persona_asociada['apellido_persona'],
        ]);
     }

    public function eliminarAlumnoCurso(Request $request)
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

    public function actualizar(Request $request) {
     
        $respuesta = $request->post();
        $validator = Validator::make($respuesta,[
            'legajo_alumno' => 'required|min:6|max:6|',
        ]);

        $alumno_existente = alumno::where('alumnos.legajo_alumno','=',$respuesta['legajo_alumno'])->get();

        if($alumno_existente->isNotEmpty()){
            if($respuesta['id'] == $alumno_existente[0]['id']){

                //Asigno el nuevo tutor a una variable
                $datos_responsable['persona_asociada'] = $respuesta['persona_tutor'];
                //Se busca el id del responsable para poder hacer el update 
                $responsableUpdate = responsable::findOrFail($alumno_existente[0]['persona_tutor']);
                \Debugbar::info($responsableUpdate);
                //Update del responsable
                responsable::whereId($responsableUpdate->id)->update($datos_responsable);
                //Se reemplaza el id de persona por el id del responsable
                $respuesta['persona_tutor'] = $responsableUpdate->id; 
                $responsableUpdate = responsable::findOrFail($alumno_existente[0]['persona_tutor']);

                alumno::whereId($respuesta['id'])->update($respuesta);
                $alumnoUpdate = alumno::findOrFail($respuesta['id']);
                $persona_asociada = Persona::findOrFail($alumnoUpdate->persona_asociada);
                $persona_tutor = Persona::findOrFail($responsableUpdate->persona_asociada);
                return response()->json([
                    '0'=>'500',
                    '1' => $alumnoUpdate->id,
                    '2' => $persona_asociada,
                    '3' => $persona_tutor,
                ]);
            }else{
                return response()->json([
                    '0'=>'El legajo se encuentra asociado a otro alumno',
                ]);    
            }    
        }else{
            //Asigno el nuevo tutor a una variable
            $datos_responsable['persona_asociada'] = $respuesta['persona_tutor'];
            //Se busca el id del responsable para poder hacer el update 
            $responsableUpdate = responsable::findOrFail($alumno_existente[0]['persona_tutor']);
            \Debugbar::info($responsableUpdate);
            //Update del responsable
            responsable::whereId($responsableUpdate->id)->update($datos_responsable);
            //Se reemplaza el id de persona por el id del responsable
            $respuesta['persona_tutor'] = $responsableUpdate->id; 
            $responsableUpdate = responsable::findOrFail($alumno_existente[0]['persona_tutor']);

            alumno::whereId($respuesta['id'])->update($respuesta);
            $alumnoUpdate = alumno::findOrFail($respuesta['id']);
            $persona_asociada = Persona::findOrFail($alumnoUpdate->persona_asociada);
            $persona_tutor = Persona::findOrFail($responsableUpdate->persona_asociada);
            return response()->json([
                '0' =>'500',
                '1' => $alumnoUpdate->id,
                '2' => $persona_asociada,
                '3' => $persona_tutor,
            ]);
        }
    }     

     public function destroy(Request $request)
    {
        $respuesta = $request->post();
        $alumno = alumno::findOrFail($respuesta['id_alumno']);

        try{
          alumno::whereId($respuesta['id_alumno'])->update(['fecha_baja' => '2013-01-01 08:00:00']);
          return response()->json([
              '0' => '500']);
        } catch (\Exception $e) {
          return response()->json([
              '0' => 'error']);
        }
        
    }

    public function restaurarAlumno(Request $request){
        $respuesta = $request->post();
        alumno::whereId($respuesta['id_alumno'])->update(['fecha_baja' => null]);
        $alumno = alumno::findOrFail($respuesta['id_alumno']);
        $responsable = responsable::findOrFail($alumno['persona_tutor']);
        $persona_asociada = Persona::findOrFail($alumno->persona_asociada);
        $persona_tutor = Persona::findOrFail($responsable->persona_asociada);
        return response()->json([
            '0' => '500',
            '1' => $alumno,
            '2' => $persona_asociada,
            '3' => $persona_tutor,
            ]);
    }            

     


}
