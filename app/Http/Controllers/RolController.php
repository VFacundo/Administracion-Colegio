<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\Permiso;
use App\Permiso_rol;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::all();
        $permisos = Permiso::all();
/*
        $data = Rol::select('rols.nombre_rol','rols.descripcion_rol','rols.estado_rol','permiso_rols.id_permiso','permisos.nombre_permiso')
                        ->join('permiso_rols','rols.nombre_rol','=','permiso_rols.nombre_rol')
                        ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                        ->get()->pluck();
        \Debugbar::info($data[0]);
*/
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

        $datRol[] = '';
        for($i=0;$i<count($roles);$i++){
          $dataRolesPr = Permiso_rol::select('permiso_rols.*','permisos.nombre_permiso')
                                    ->join('permisos','permisos.id','=','permiso_rols.id_permiso')
                                    ->where('permiso_rols.nombre_rol','=',$roles[$i]['nombre_rol'])
                                    ->get();
          //$roles += ['permisos' => $dataRolesPr];
          $roles[$i]['permisos'] = $dataRolesPr;

        }
                  \Debugbar::info($roles);
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
          Permiso_rol::create(['id_permiso'=>$value,'nombre_rol'=>$respuesta['nombre_rol'],'fecha_asignacion'=>'NOW()']);
        }
        return response()->json([
        '0' => '500',
        '1' => $respuesta['nombre_rol'],]);
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
    public function destroy($id)
    {
        //
    }
}
