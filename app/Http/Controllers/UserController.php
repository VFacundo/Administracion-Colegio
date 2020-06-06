<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\UserNotification;
use App\User;
use App\Persona;
use App\tipo_documento;
use App\Rol;
use App\Rol_usuario;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

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
        $rolesT = Rol::get('rols.nombre_rol');
        //$roles = json_decode($rolesDb->get()->getContents())[0];
        for($i=0;$i<sizeof($usuariosRegistrados);$i++){
            $persona = Persona::findOrFail($usuariosRegistrados[$i]['id_persona']);
            $usuariosRegistrados[$i]['persona'] = $persona['nombre_persona'] . ' ' . $persona['apellido_persona'];
            $usuariosRegistrados[$i]['personaString'] = "Cuil: " . $persona['cuil_persona'] . "<br>" . "Domicilio: " . $persona['domicilio'] . "<br>" . "Fecha Nac.: " . $persona['fecha_nacimiento'];
            $rolUser = Rol_usuario::select('rol_usuarios.*')->where('rol_usuarios.id_usuario','=',$usuariosRegistrados[$i]['id'])->get();
            $usuariosRegistrados[$i]['rolesUser'] = $rolUser;
        }
        return view('usuarios.index',compact('usuariosRegistrados'),compact('rolesT'));
    }

    public function refreshTable(Request $request){
      $usuariosRegistrados = User::all();
      //$roles = json_decode($rolesDb->get()->getContents())[0];
      for($i=0;$i<sizeof($usuariosRegistrados);$i++){
          $persona = Persona::findOrFail($usuariosRegistrados[$i]['id_persona']);
          $usuariosRegistrados[$i]['persona'] = $persona['nombre_persona'] . ' ' . $persona['apellido_persona'];
          $rolUser = Rol_usuario::select('rol_usuarios.*')->where('rol_usuarios.id_usuario','=',$usuariosRegistrados[$i]['id'])->get();
          $usuariosRegistrados[$i]['rolesUser'] = $rolUser;
      }
      return response()->json([
        '0' => $usuariosRegistrados,]);
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
          $respuesta = $request->post();
          $validator = Validator::make($request->all(),[
            'name' => 'required|unique:Users|max:255',
            'password' => 'required|max:255',
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
          $validatedData=['name'=>$respuesta['name'],
                          'password' => $respuesta['password'],
                          'email' => $respuesta['email'],
                          'id_persona' => $respuesta['id_persona'],
        ];
          try{
            $newUser = User::create($validatedData);
            for($i=0;$i<sizeof($respuesta['roles']);$i++){
              $rolUser = ['id_usuario'=>$newUser->id,'nombre_rol'=>$respuesta['roles'][$i]];
              Rol_usuario::create($rolUser);
            }
            }catch (\Exception $e) {
              return response()->json([
                  '0' => 'error']);
          }

          return response()->json([
            '0' => '500',]);
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
        return view('usuarios.index');
    }

    public function editar(Request $Request)
    {
        $respuesta = $Request->post();
        $usuario = User::findOrFail($respuesta['id']);
        $rolUser = Rol_usuario::select('rol_usuarios.*')->where('rol_usuarios.id_usuario','=',$usuario['id'])->get();
        //var_dump($_POST);
    return response()->json([
      'id' => $usuario['id'],
      'name' => $usuario['name'],
      'email' => $usuario['email'],
      'id_persona' => $usuario['id_persona'],
      'roles' => $rolUser,]);
    }

    public function actualizar(Request $request)
    {
      $respuesta = $request->post();
      $origData = User::whereId($respuesta['id'])->get();
      if(($origData[0]['name']!=$respuesta['name'])){
        $validator = Validator::make($request->all(),[
          'name' => 'required|unique:users|max:255',
        ]);
        if($validator->fails()){
          $errors = $validator->errors();
          foreach($errors->all() as $message){
            $arrayErrores[] = $message;
          }
          return json_encode($arrayErrores);
        }
      }
      if(($origData[0]['email']!=$respuesta['email'])){
        $validator = Validator::make($request->all(),[
          'email' => 'required|email|unique:users|max:255',
        ]);
        if($validator->fails()){
          $errors = $validator->errors();
          foreach($errors->all() as $message){
            $arrayErrores[] = $message;
          }
          return json_encode($arrayErrores);
        }
      }
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
        Rol_usuario::where('id_usuario','=',$respuesta['id'])->delete();
        for($j=0;$j<count($respuesta['roles']);$j++){
          $regNusR = ['id_usuario'=>$respuesta['id'],'nombre_rol'=>$respuesta['roles'][$j]];
          Rol_usuario::create($regNusR);
        }
        unset($respuesta['roles']);
        User::whereId($respuesta['id'])->update($respuesta);
        $userN = User::findOrFail($respuesta['id']);
        User::all()
              ->except($userN->id)
              ->each(function(User $user) use ($userN){
                $user->notify(new UserNotification($userN));
              });

        return response()->json([
          '0' => '500']);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /*
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
*/
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $respuesta = $request->post();
        try{
          Rol_usuario::where('id_usuario','=',$respuesta['id'])->delete();
          $usuarioRegistrado = User::findOrFail($respuesta['id']);
          \Debugbar::info($usuarioRegistrado);
          $usuarioRegistrado->delete();
          return response()->json([
              '0' => '500']);
        }catch(\Exception $e){
          return response()->json([
              '0' => 'error']);
        }
    }

    public function update(Request $request){
      $respuesta = $request->post();
      $user = User::findOrFail($respuesta['id']);

      return response()->json([
        'Username'=>$user['name'],
        'email'=>$user['email'],
      ]);
    }

    public function install(){
      $tipo_documento = [
        'nombre_tipo' => 'DNI',
        'descripcion' => 'Documento Nacional de Identidad',
      ];
      tipo_documento::create($tipo_documento);

      $persona = [
        'legajo' => '000000',
        'nombre_persona' => 'Administrador',
        'apellido_persona' => 'Administrador',
        'tipo_documento' => 1,
        'dni_persona' => '00000000',
        'cuil_persona' => '00000000',
        'domicilio' => 'Rawson',
        'fecha_nacimiento' => '2020/06/06',
        'numero_telefono' => '0000000000',
        'estado_persona' => 'activo',
      ];
      $personaInsert = Persona::create($persona);
      $usuario = [
        'name' => 'admin',
        'email' => 'admin@colegio.com',
        'password' => 'admin',
        'id_persona' => $personaInsert->id,
      ];
      $registerUser = new RegisterController();
      $registerUser->create($usuario);
    }
}
