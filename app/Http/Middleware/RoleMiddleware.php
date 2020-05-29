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
          Auth::logout();
          abort(403,'Para ingresar al sistema debes Activar tu Cuenta!');
        }
        return $next($request);
    }
}
