<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permiso;
use Illuminate\Support\Facades\Validator;

class PermisoController extends Controller
{
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
        'nombre_permiso' => 'required|unique:Permisos|max:255',
        'funcionalidad_permiso' => 'required|max:255',
        'estado_permiso' => 'required|estado_correcto',
        'descripcion_permiso' => 'required|max:255',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        $permisoInsert = Permiso::create($respuesta);
        return response()->json([
          '0' => '500',
          '1' => $permisoInsert->id,]);
      }
    }

/*
*Obtiene la informacion de un permiso para enviar a la vista
*/
    public function update(Request $request){
      $respuesta = $request->post();
      $permiso = Permiso::findOrFail($respuesta['id']);
  return response()->json([
    'id' => $permiso['id'],
    'nombre_permiso'=> $permiso['nombre_permiso'],
    'funcionalidad_permiso'=> $permiso['funcionalidad_permiso'],
    'descripcion_permiso'=> $permiso['descripcion_permiso'],
    'estado_permiso'=> $permiso['estado_permiso'],
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
       $validator = Validator::make($request->all(),[
         'nombre_permiso' => 'required|max:255',
         'funcionalidad_permiso' => 'required|max:255',
         'estado_permiso' => 'required|estado_correcto',
         'descripcion_permiso' => 'required|max:255',
       ]);

       if($validator->fails()){
         $errors = $validator->errors();
         foreach($errors->all() as $message){
           $arrayErrores[] = $message;
         }
         return json_encode($arrayErrores);
       }else{
         Permiso::whereId($respuesta['id'])->update($respuesta);
         return response()->json([
           '0' => '500',]);
       }
    }

    public function destroy(Request $request){
      $respuesta = $request->post();
      $permiso = Permiso::findOrFail($respuesta['id']);
      try{
        $permiso->delete();
        return response()->json([
            '0' => '500']);
      }catch(Exception $e){
        return response()->json([
            '0' => 'error']);
      }
    }
}
