<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\alumno;
use App\alumno_curso;
use App\Persona;
use App\personal;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personals = personal::whereNull('personals.fecha_baja')->get();

        for($i=0;$i<sizeof($personals);$i++){
          $persona = Persona::findOrFail($personals[$i]['id_persona']);
          $personals[$i]['nombrePersona'] = $persona['nombre_persona'];
          $personals[$i]['apellidoPersona'] = $persona['apellido_persona'];
          $personals[$i]['persona'] = $persona['nombre_persona'] . ' ' . $persona['apellido_persona'];
          $personals[$i]['personaString'] = "CUIL: " . $persona['cuil_persona'] . "<br>" . "Domicilio: " . $persona['domicilio'] . "<br>" . "Tel.: " . $persona['numero_telefono'];
        }

        $personas = Persona::select('personas.*')
                ->leftjoin('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                ->whereNull('alumnos.persona_asociada')
                ->get();


        return view('personal.index',compact('personals'),compact('personas'));

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
            'legajo_personal' => 'required|min:6|max:6|',
        ]);

        $personal_existente = personal::where('personals.legajo_personal','=',$respuesta['legajo_personal'])->get();
        $personal_baja = personal::select('personals.*')
                                     ->where('personals.fecha_baja', "<>", null)
                                     ->where('personals.legajo_personal','=',$respuesta['legajo_personal'])
                                     ->get();

        if($validator->fails()){
            $errors = $validator->errors();
                foreach($errors->all() as $message){
                    $arrayErrores[] = $message;
                }
            return response()->json([
                '0' => ($arrayErrores),
            ]);
        }else{
            if($personal_existente->isNotEmpty() && $personal_baja->isNotEmpty()){
                return response()->json([
                    '0' =>'1',
                    '1' => $personal_existente,
                ]);
            }elseif ($personal_existente->isNotEmpty()) {
                        return response()->json([
                            '0' => 'El numero de legajo ya existe',
                        ]);        
            }else{
                $personalInsert = personal::create($respuesta);
                $persona_asociada = Persona::findOrFail($personalInsert->id_persona);
                return response()->json([  
                    '0' => '500',
                    '1' => $personalInsert,
                    '2' => $persona_asociada,
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
    public function destroy(Request $request)
    {
        $respuesta = $request->post();
        $personal = personal::findOrFail($respuesta['id_personal']);

        try{
          personal::whereId($respuesta['id_personal'])->update(['fecha_baja' => '2013-01-01 08:00:00']);
          return response()->json([
              '0' => '500']);
        } catch (\Exception $e) {
          return response()->json([
              '0' => 'error']);
        }
        
    }

    public function listar_personal(Request $request){

        $personas_personal = Persona::select('personas.*')
                   ->leftjoin('alumnos', 'personas.id' , '=', 'alumnos.persona_asociada')
                   ->leftjoin('personals', 'personas.id' , '=', 'personals.id_persona')
                   ->whereNull('alumnos.persona_asociada')
                   ->whereNull('personals.id_persona')
                   ->get();
   
        return response()->json(['personas_personal'=>$personas_personal]);       
    } 


    public function editar(Request $Request)
    {
        $respuesta = $Request->post();
        $personal = personal::findOrFail($respuesta['id']);
        $persona_asociada = Persona::findOrFail($personal->id_persona);
        
     return response()->json([
           'id' => $personal['id'],
           'legajo_personal' => $personal['legajo_personal'],
           'id_persona' => $personal['id_persona'],
           'fecha_baja' => $personal['fecha_baja'],
           'fecha_alta' => $personal['fecha_alta'],
           'manejo_de_grupo' => $personal['manejo_de_grupo'],
           'nombre_personal' => $persona_asociada['nombre_persona'],
           'apellido_personal' => $persona_asociada['apellido_persona'],
        ]);
    }

    public function actualizar(Request $request) {
     
        $respuesta = $request->post();
        $validator = Validator::make($respuesta,[
            'legajo_personal' => 'required|min:6|max:6|',
        ]);

        $personal_existente = personal::where('personals.legajo_personal','=',$respuesta['legajo_personal'])->get();

        if($personal_existente->isNotEmpty()){
            if($respuesta['id'] == $personal_existente[0]['id']){
                personal::whereId($respuesta['id'])->update($respuesta);
                $personalUpdate = personal::findOrFail($respuesta['id']);
                $persona_asociada = Persona::findOrFail($personalUpdate->id_persona);
                return response()->json([
                    '0'=>'500',
                    '1' => $personalUpdate,
                    '2' => $persona_asociada,
                ]);
            }else{
                return response()->json([
                    '0'=>'El legajo se encuentra asociado a otro personal',
                ]);    
            }    
        }else{
            $personalUpdate = personal::whereId($respuesta['id'])->update($respuesta);
            $persona_asociada = Persona::findOrFail($personalUpdate->id_persona);
           
            return response()->json([
                '0' =>'500',
                '1' => $personalUpdate->id,
                '2' => $persona_asociada,
            ]);
        }
    }

    public function restaurarPersonal(Request $request){
        $respuesta = $request->post();
        personal::whereId($respuesta['id_personal'])->update(['fecha_baja' => null]);
        $personal = personal::findOrFail($respuesta['id_personal']);
        $persona_asociada = Persona::findOrFail($personal->id_persona);
        return response()->json([
            '0' => '500',
            '1' => $personal,
            '2' => $persona_asociada,
            ]);
    }     


}
