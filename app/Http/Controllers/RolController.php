<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\Permiso;
use App\Permiso_rol;

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
      $validatedData = $request->validate([
        'nombre_rol' => 'required|max:255',
        'descripcion_rol' => 'required|max:255',
        'estado_rol' => 'required|max:255',
      ]);

      User::create($validatedData);
        return redirect('/roles')->with('success','Usuario Creado Correctamente');
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
