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
        $ciclos = ciclo_lectivo::all();
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
      \Debugbar::info($respuesta);
       $cicloInsert = ciclo_lectivo::create($respuesta);
         return response()->json([
          '0' => '500',
          '1' => $cicloInsert->id,]);
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

    ciclo_lectivo::whereId($respuesta['id'])->update($respuesta);
         return response()->json([
            '0'=>'500',
           ]);
    }   

}
