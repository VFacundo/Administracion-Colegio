<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = User::findOrFail(Auth::id());
        if(strcasecmp($user['estado_usuario'],'inactivo') == 0){
          //Auth::logout();
          //abort(403,'Para ingresar al sistema debes Activar tu Cuenta!');
          //return redirect()->route('verificar.index',\Crypt::encrypt(['idUser'=>$user['id'],'idPersona'=>$user['idPersona']]));
          return redirect()->route('verificar.index');
        }
        return $next($request);
    }
}
