<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuariosRegistrados = User::all();
        for($i=0;$i<sizeof($usuariosRegistrados);$i++){
            $persona = Persona::findOrFail($usuariosRegistrados[$i]['id_persona']);
            $usuariosRegistrados[$i]['persona'] = $persona['nombre_persona'] . ' ' . $persona['apellido_persona'];
        }
        return view('usuarios.index',compact('usuariosRegistrados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
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
          'name' => 'required|max:255',
          'password' => 'required|max:255',
          'email' => 'required|max:255',
          'id_persona' => 'required|numeric',
        ]);

        User::create($validatedData);
        return redirect('/usuarios')->with('success','Usuario Creado Correctamente');
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
        return view('usuarios.index');
    }

    public function editar(Request $Request)
    {
        $respuesta = $Request->post();
        $usuario = User::findOrFail($respuesta['id']);
        //var_dump($_POST);
    return response()->json([
      'id' => $usuario['id'],
      'name' => $usuario['name'],
      'email' => $usuario['email'],
      'id_persona' => $usuario['id_persona']]);
    }

    public function actualizar(Request $request)
    {
      $respuesta = $request->post();
      $validator = Validator::make($request->all(),[
        'name' => 'required|max:255',
        'email' => 'required|max:255',
        'id_persona' => 'required|numeric',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        User::whereId($respuesta['id'])->update($respuesta);
        return response()->json([
          'error' => 'no error']);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $respuesta = $request->post();
      $validatedData = $respuesta->validate([
        'name' => 'required|max:255',
        'password' => 'required|max:255',
        'email' => 'required|max:255',
        'id_persona' => 'required|numeric',
      ]);
      User::whereId($request['id'])->update($validatedData);
      //return redirect('/usuarios')->with('success','Usuario Modificado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuarioRegistrado = User::findOrFail($id);
        $usuarioRegistrado->delete();

        return redirect('/usuarios')->with('success','Usuario Eliminado Correctamente');
    }
}
