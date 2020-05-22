<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\tipo_documento;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;


class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::all();
        $tipo_documento = tipo_documento::all();
        return view('personas.index',compact('personas'),compact('tipo_documento'));
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

        $validatedData = $request->validate([
          'legajo' => 'required|max:255|',
          'nombre_persona' => 'required|alpha|max:255',
          'apellido_persona' => 'required|alpha|max:255',
          'tipo_documento' => 'required',
          'dni_persona' => 'required|numeric|digits_between:7,8',
          'cuil_persona' => 'required|numeric|digits_between:10,11',
          'domicilio' => 'required|max:255',
          'fecha_nacimiento' => 'required|date',
          'numero_telefono' => 'required',
        ]);
          $personaInsert = Persona::create($validatedData);
          $usuario = [
            'name' => $validatedData['legajo'],
            'email' => $validatedData['nombre_persona'] . '@' . $validatedData['legajo'] . '.com',
            'password' => $validatedData['dni_persona'],
            'id_persona' => $personaInsert->id,
          ];
          $registerUser = new RegisterController();
          $registerUser->create($usuario);
        return redirect('/personas')->with('success','Persona Creada Correctamente');
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
     /*
     * function editar() Return un json con la informacion de la persona con la ID solicitada.
     */
     public function editar(Request $Request)
     {
         $respuesta = $Request->post();
         $persona = Persona::findOrFail($respuesta['id']);
         //var_dump($_POST);
     return response()->json([
       'id' => $persona['id'],
       'legajo' => $persona['legajo'],
       'nombre_persona' => $persona['nombre_persona'],
       'apellido_persona' => $persona['apellido_persona'],
       'tipo_documento' => $persona['tipo_documento'],
       'dni_persona' => $persona['dni_persona'],
       'cuil_persona' => $persona['cuil_persona'],
       'domicilio' => $persona['domicilio'],
       'fecha_nacimiento' => $persona['fecha_nacimiento'],
       'numero_telefono' => $persona['numero_telefono'],
       'estado_persona' => $persona['estado_persona'],
        ]);
     }

     /*
     function actualizar, actualiza la persona, recibe por ajax
     */
     public function actualizar(Request $request)
     {
       $respuesta = $request->post();
       \Debugbar::info($respuesta);

       Validator::extend('estado_correcto', function($attribute, $value){
         if ((strcasecmp($value, "activo") === 0) || (strcasecmp($value, "inactivo") === 0)){
           return true;
         }else{
           return false;
         }
        });

       $validator = Validator::make($request->all(),[
         'legajo' => 'required|max:255',
         'nombre_persona' => 'required|max:255',
         'apellido_persona' => 'required|max:255',
         'tipo_documento' => 'required',
         'dni_persona' => 'required|max:255',
         'cuil_persona' => 'required|numeric|digits_between:10,11',
         'domicilio' => 'required|max:255',
         'fecha_nacimiento' => 'required|date',
         'numero_telefono' => 'required|max:255',
         'estado_persona' => 'required|estado_correcto',
       ]);

       if($validator->fails()){
         $errors = $validator->errors();
         foreach($errors->all() as $message){
           $arrayErrores[] = $message;
         }
         \Debugbar::info($arrayErrores);
         return json_encode($arrayErrores);
       }else{
         Persona::whereId($respuesta['id'])->update($respuesta);
         return response()->json([
           '0' => '500']);
       }
     }

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
        $persona = Persona::findOrFail($respuesta['id']);
        $persona->delete();

        return response()->json([
            '0' => '500']);
    }
}
