<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $redirectTo = '/home';
    protected $name;
/*
    public function username()
    {
    return 'name';
    }
*/

/*
    protected function authenticated2(){
      if(Auth::check()){
        $userId = Auth::id();
        $usuario = User::findOrFail($userId);
                      \Debugbar::warning($usuario);
          if(strcasecmp($usuario['estado_usuario'],'inactivo') == 0){
              \Debugbar::info("falso");
          }else{
            return redirect()->route('personas.index');
          }
      }
    }
*/

    /**
 * The user has been authenticated.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  mixed  $user
 * @return mixed
 */
 /**
    protected function authenticated(Request $request, $user){
      $userId = Auth::id();
      $usuario = User::findOrFail($userId);
      //if(strcasecmp($usuario['estado_usuario'],'inactivo') == 0){
      //  return abort(404);
    //  }else{
        return redirect()->route('personas.index');
    //  }
      //return redirect()->route('personas.index');
    }
**/

    /**
     * Where to redirect users after login.
     *
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->name = $this->findUsername();
    }

    public function findUsername(){
      $login = request()->input('login');
      $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
      request()->merge([$fieldType=>$login]);
      return $fieldType;
    }

    public function username(){
      return $this->name;
    }
}
