<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\Permiso;
use App\Permiso_rol;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{

  public function rolesArray(){
    $roles = Rol::all();
    for($i=0;$i<count($roles);$i++){
      $dataRolesPr = Permiso_rol::select('permiso_rols.*','permisos.nombre_permiso')
                                ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                                ->where('permiso_rols.nombre_rol','=',$roles[$i]['nombre_rol'])
                                ->get();
      //$roles += ['permisos' => $dataRolesPr];
      $roles[$i]['permisos'] = $dataRolesPr;
    }
    return $roles;
  }

  public function rolesArrayId($id){
      $dataRolesPr = Permiso_rol::select('permiso_rols.*','permisos.nombre_permiso')
                                ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                                ->where('permiso_rols.nombre_rol','=',$id)
                                ->get();
      //$roles += ['permisos' => $dataRolesPr];
      //$roles[$i]['permisos'] = $dataRolesPr;
    return $dataRolesPr;
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$roles = Rol::all();
        $permisos = Permiso::all();

/*
        $dataRoles = Rol::select('rols.nombre_rol','rols.descripcion_rol','rols.estado_rol','permiso_rols.id_permiso','permisos.nombre_permiso')
                        ->join('permiso_rols','rols.nombre_rol','=','permiso_rols.nombre_rol')
                        ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                        ->get('rols.*','permiso_rols.id_permiso','permisos.nombre_permiso');
        \Debugbar::info($dataRoles);

        $dataRolesPr = Permiso_rol::select('permiso_rols.*','permisos.nombre_permiso')
                                  ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                                  ->where('permiso_rols.nombre_rol','=','admin')
                                  ->get();
        \Debugbar::info($dataRolesPr);

        for($i=0;$i<count($roles);$i++){
          $dataRolesPr = Permiso_rol::select('permiso_rols.*','permisos.nombre_permiso')
                                    ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                                    ->where('permiso_rols.nombre_rol','=',$roles[$i]['nombre_rol'])
                                    ->get();
          //$roles += ['permisos' => $dataRolesPr];
          $roles[$i]['permisos'] = $dataRolesPr;
        $roles = rolesArray();
        }
        */
        $roles = $this->rolesArray();
        return view('roles.index',compact('roles'),compact('permisos'));
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
    public function store(Request $request){
      $respuesta = $request->post();

      //Validador Custom para los estados
      Validator::extend('estado_correcto', function($attribute, $value){
        if ((strcasecmp($value, "activo") === 0) || (strcasecmp($value, "inactivo") === 0)){
          return true;
        }else{
          return false;
        }
       });

      $validator = Validator::make($request->all(),[
        'nombre_rol' => 'required|unique:rols|max:255',
        'descripcion_rol' => 'required|max:255',
        'estado_rol' => 'required|max:255',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        $rolInsert = rol::create($respuesta);
        foreach ($respuesta['permisos'] as $key => $value) {
          $registroPr = ['id_permiso'=>$value,'nombre_rol'=>$respuesta['nombre_rol'],'fecha_asignacion_permiso'=>date("Y").'/'.date("m").'/'.date("d")];
          Permiso_rol::create($registroPr);
        }
        $rolesArrayRespuesta = $this->rolesArrayId($respuesta['nombre_rol']);
        //$rolesArrayRespuesta = $rolesArrayRespuesta[sizeof($rolesArrayRespuesta)];
        return response()->json([
        '0' => '500',
        '1' => $rolesArrayRespuesta,]);
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
    public function update(Request $request){
      $respuesta = $request->post();
      $rol = Rol::select('rols.*')
            ->where('rols.nombre_rol','=',$respuesta['id'])
            ->get();
      //$rol = Rol::findOrFail($nombre_rol);
      return response()->json([
        'nombre_rol'=>$rol[0]['nombre_rol'],
        'descripcion_rol'=>$rol[0]['descripcion_rol'],
        'estado_rol'=>$rol[0]['estado_rol'],
        'permisos' => $this->rolesArrayId($rol[0]['nombre_rol']),
      ]);
    }

    public function setUpdate(Request $request){
      $respuesta = $request->post();
      //validador custom estado
      Validator::extend('estado_correcto', function($attribute, $value){
        if ((strcasecmp($value, "activo") === 0) || (strcasecmp($value, "inactivo") === 0)){
          return true;
        }else{
          return false;
        }
       });
       ////
       if($respuesta['id'] == $respuesta['nombre_rol']){
         $validator = Validator::make($request->all(),[
           'descripcion_rol' => 'required|max:255',
           'estado_rol' => 'required|estado_correcto',
         ]);
       }else{
         $validator = Validator::make($request->all(),[
            'nombre_rol' => 'required|unique:rols|max:255',
           'descripcion_rol' => 'required|max:255',
           'estado_rol' => 'required|estado_correcto',
         ]);
       }
       if($validator->fails()){
         $errors = $validator->errors();
         foreach($errors->all() as $message){
           $arrayErrores[] = $message;
         }
         return json_encode($arrayErrores);
       }else{
         $rolUpdate = ['nombre_rol'=>$respuesta['nombre_rol'],'descripcion_rol'=>$respuesta['descripcion_rol'],'estado_rol'=>$respuesta['estado_rol']];
         Permiso_rol::where('nombre_rol','=',$respuesta['id'])->delete();
         Rol::where('nombre_rol','=',$respuesta['id'])->update($rolUpdate);

         foreach ($respuesta['permisos'] as $key => $value) {
           $registroPr = ['id_permiso'=>$value,'nombre_rol'=>$respuesta['nombre_rol'],'fecha_asignacion_permiso'=>date("Y").'/'.date("m").'/'.date("d")];
           Permiso_rol::create($registroPr);
         }

         return response()->json([
           '0' => '500',]);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
      $respuesta = $request->post();
      try {
        //$rol->delete();
        Permiso_rol::where('nombre_rol','=',$respuesta['id'])->delete();
        $rol = Rol::where('nombre_rol','=',$respuesta['id'])->delete();
        return response()->json([
            '0' => '500']);
      } catch (\Exception $e) {
        return response()->json([
            '0' => 'error']);
      }

    }
}
