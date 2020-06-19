<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class VerificarMailController extends Controller
{
    public function index(){//In idUser, idPersona
      //$user = \Crypt::decrypt($user);

      //$userV = User::find($id);
      //$userV->email = 'facuviola73@gmail.com';
      //$userV->save();
      //$userV->sendEmailVerificationNotification();
      return view('verificar.index');
    }

    public function verificar(Request $Request){
      $respuesta = $Request->Post();
      $userV = User::find(Auth::id());
      $userV->email = $respuesta['mail'];
      $userV->save();
      $userV->sendEmailVerificationNotification();
    }

    public function verificado(){
      $userV = User::find(Auth::id());
      $userV->estado_usuario = 'activo';
      $userV->save();
      Auth::logout();
    return view('verificar.verificado');
    }
}
