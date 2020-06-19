<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ciclo_lectivo;
use App\curso;
use Illuminate\Support\Facades\Validator;


class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciclos = ciclo_lectivo::select('ciclo_lectivos.*')
                                ->whereNull('ciclo_lectivos.fecha_baja')->get();
        $cursos = curso::all();
        return view('ciclos.index',compact('ciclos'),compact('cursos'));
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
  /**  public function store(Request $request){
      $respuesta = $request->post();
      \Debugbar::info($respuesta);
      $validator = Validator::make($request->all(),[
        'anio' => 'required|min:4|max:4',
        'nombre' => 'max:255',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        $cicloInsert = ciclo_lectivo::create($respuesta);
        return response()->json([
          '0' => '500',
          '1' => $cicloInsert->id,]);
      }
    }
**/

    public function store(Request $request){
        $respuesta = $request->post();
        $validator = Validator::make($respuesta,[
            'anio' => 'required|min:4|max:4',
        ]);
        $cicloExistente = ciclo_lectivo::where('ciclo_lectivos.anio', '=' , $respuesta['anio'])->get();
        $ciclos_baja = ciclo_lectivo::select('ciclo_lectivos.*')
                                     ->where('ciclo_lectivos.fecha_baja', "<>", null)
                                     ->where('ciclo_lectivos.anio', '=', $respuesta['anio'])
                                     ->get();
        if (($cicloExistente->isNotEmpty()) && ($ciclos_baja->isNotEmpty())){
                    return response()->json([
                    '0' => '1',
                    '1' => $cicloExistente,
                    ]);
        }elseif (($cicloExistente->isNotEmpty())){ 
                return response()->json([
                '0' => 'El ciclo lectivo ya existe',]);           
        }else{
            if($validator->fails()){
                $errors = $validator->errors();
                    foreach($errors->all() as $message){
                        $arrayErrores[] = $message;
            }
                return json_encode($arrayErrores);
            }else{
                $cicloInsert = ciclo_lectivo::create($respuesta);
                return response()->json([
                    '0' => '500',
                    '1' => $cicloInsert->id,]);
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
    
    public function editar(Request $Request) {
         $respuesta = $Request->post();
         $ciclo = ciclo_lectivo::findOrFail($respuesta['id']);
         //var_dump($_POST);
        return response()->json([
            'id' => $ciclo['id'],
            'anio' => $ciclo['anio'],
            'nombre' => $ciclo['nombre'],
        ]);
    }

    public function actualizar(Request $request) {
        $respuesta = $request->post();
        $validator = Validator::make($respuesta,[
            'anio' => 'required|min:4|max:4',
        ]);
        $cicloExistente = ciclo_lectivo::where('ciclo_lectivos.anio', '=' , $respuesta['anio'])->get();
        \Debugbar::info($cicloExistente);
        $cursos = curso::select('cursos.*')->where('cursos.id_ciclo_lectivo', '=', $respuesta['id'])->get();                              

        if ($cursos->isNotEmpty()){
            return response()->json([
                    '0' => 'El ciclo no se puede editara porque tiene cursos asociados',]);
        }elseif (($cicloExistente->isNotEmpty())){
            return response()->json([
                    '0' => 'El ciclo lectivo ya existe',]);
        }else{
            if($validator->fails()){
                $errors = $validator->errors();
                    foreach($errors->all() as $message){
                        $arrayErrores[] = $message;
            }
                return json_encode($arrayErrores);
            }else{
                ciclo_lectivo::whereId($respuesta['id'])->update($respuesta);
                return response()->json([
                '0'=>'500',
                '1'=> $respuesta['anio'],
                '2'=> $respuesta['id'],]);
            }
        }
    }       

  public function destroy(Request $request)
    {
        $respuesta = $request->post();
        $ciclo_lectivo = ciclo_lectivo::select('ciclo_lectivos.*')
                                      ->join('cursos', 'cursos.id_ciclo_lectivo' , '=', 'ciclo_lectivos.id')
                                      ->where('ciclo_lectivos.id' , '=' , $respuesta['id_ciclo'])
                                      ->get();

        if ($ciclo_lectivo->isNotEmpty()){
            ciclo_lectivo::whereId($respuesta['id_ciclo'])->update(['fecha_baja' => '2013-01-01 08:00:00']);
            return response()->json([
                '0' => 'error']);
        }else{
            ciclo_lectivo::whereId($respuesta['id_ciclo'])->delete();
            return response()->json([
                '0' => '500']);
        }
    } 

    public function restaurarCiclo(Request $request){
        $respuesta = $request->post();
        ciclo_lectivo::whereId($respuesta['id_ciclo'])->update(['fecha_baja' => null]);
        $ciclo = ciclo_lectivo::findOrFail($respuesta['id_ciclo']);
        return response()->json([
            '0' => '500',
            '1' => $ciclo,
            ]);
    }


}
