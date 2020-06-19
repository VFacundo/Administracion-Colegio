<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\noticia;
use App\User;
use App\Persona;

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
      \Debugbar::info($respuesta);

      return response()->json([
        '0' => '500'
      ]);
    }
}
