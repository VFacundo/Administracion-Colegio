<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{

    public function login(){
      return view('usuarios.login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuariosRegistrados = Usuario::all();
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
          'legajo' => 'required|max:255',
          'username' => 'required|max:255',
          'password' => 'required|max:255',
          'mail' => 'required|max:255',
          'id_persona' => 'required|numeric',
        ]);
        var_dump($validatedData);
        $show = Usuario::create($validatedData);
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
        $usuario = Usuario::findOrFail($respuesta['id']);
        //var_dump($_POST);
    return response()->json([
      'legajo' => $usuario['legajo'],
      'username' => $usuario['username'],
      'mail' => $usuario['mail'],
      'id_persona' => $usuario['id_persona']]);
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
      $validatedData = $request->validate([
        'legajo' => 'required|max:255',
        'username' => 'required|max:255',
        'password' => 'required|max:255',
        'mail' => 'required|max:255',
        'id_persona' => 'required|numeric',
      ]);
      Usuario::whereId($id)->update($validatedData);
      return redirect('/usuarios')->with('success','Usuario Modificado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuarioRegistrado = Usuario::findOrFail($id);
        $usuarioRegistrado->delete();

        return redirect('/usuarios')->with('success','Usuario Eliminado Correctamente');
    }
}
