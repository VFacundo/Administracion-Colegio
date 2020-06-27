<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\NoticiaNotification;
use App\noticia;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NoticiaController extends Controller
{
    public function index(){
      $noticias = noticia::all();

      for($i=0;$i<sizeof($noticias);$i++){
        $user = User::findOrFail($noticias[$i]['noticias_usuarios_generador']);
        $persona = Persona::findOrFail($user['id_persona']);
        $noticias[$i]['persona_asociada'] = $persona['nombre_persona'] . ' ' . $persona['apellido_persona'];
        \Debugbar::info($noticias[$i]['persona_asociada']);
      }

      return view('noticias.index',compact('noticias'));
    }

    public function create(Request $request){
      $respuesta = $request -> post();

      $validator = Validator::make($request->all(),[
        //'legajo' => 'required|max:255',
        'descripcion_noticia' => 'required',
        'titulo_noticia' => 'required|max:255',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        $news = noticia::create(['descripcion_noticia'=>$respuesta['descripcion_noticia'],
                        'titulo_noticia'=>$respuesta['titulo_noticia'],
                        'fecha_origen'=>date("Y-m-d"),
                        'noticias_usuarios_generador'=>Auth::id(),
                      ]);

        User::all()
          ->except(Auth::id())
          ->each(function(User $user) use ($news){
            if(strcasecmp($user['estado_usuario'],'activo') == 0){
          $user->notify(new NoticiaNotification($news));
          }
          });

        return response()->json([
          '0' => '500',
          '1' => $news->id]);
      }
    }

    public function destroy(Request $request){
        $respuesta = $request->post();

        try{
          $noticia = noticia::findOrFail($respuesta['id']);

          $noticia->delete();
            return response()->json(['0'=>'500']);
        }catch(\Exception $e){
          return response()->json([
            '0'=>'error',
            '1'=>'La Noticia no se pudo Eliminar'
          ]);
        }
    }

    public function editar(Request $request){
      $respuesta = $request->post();
      $noticia = noticia::findOrFail($respuesta['id']);
      return response()->json([
        'id' => $noticia['id'],
        'titulo_noticia' => $noticia['titulo_noticia'],
        'descripcion_noticia' => $noticia['descripcion_noticia'],
      ]);
    }

    public function actualizar(Request $request){
      $respuesta = $request -> post();
      \Debugbar::info($respuesta);
      $validator = Validator::make($request->all(),[
        //'legajo' => 'required|max:255',
        'descripcion_noticia' => 'required',
        'titulo_noticia' => 'required|max:255',
      ]);

      if($validator->fails()){
        $errors = $validator->errors();
        foreach($errors->all() as $message){
          $arrayErrores[] = $message;
        }
        return json_encode($arrayErrores);
      }else{
        noticia::whereId($respuesta['id'])->update(['descripcion_noticia'=>$respuesta['descripcion_noticia'],
                        'titulo_noticia'=>$respuesta['titulo_noticia'],
                      ]);
        return response()->json([
          '0' => '500']);
      }
    }
}
