<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistema Administracion Colegio</title>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{{ asset('js/emergente.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/ajaxData.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataRoles.js') }}"></script>
</head>
<body>
  <!--NAV INICIO -->
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <!--
          <a class="navbar-brand" href="{{ url('/') }}">
              {{ config('app.name', '-') }}
          </a>
        -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav mr-auto">

              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ml-auto">
                  <!-- Authentication Links -->
                  @guest
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                      </li>
                      @if (Route::has('register'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                          </li>
                      @endif
                  @else
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  {{ __('Logout') }}
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  @endguest
              </ul>
          </div>
      </div>
  </nav>
  <!-- NAV FIN -->

  <div class="jumbotron text-center">
    <h1>Sistema de Administracion</h1>
    <p>-Colegio Nro 2 Rawson-</p>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="list-group">
            <a href="{{route('personas.index')}}" class="list-group-item">Administracion de Personas</a>
            <a href="{{route('usuarios.index')}}" class="list-group-item">Administracion de Usuarios</a>
            <a href="{{route('roles.index')}}" class="list-group-item">Administracion de Roles</a>
            <a href="#" class="list-group-item">Noticias</a>
            <a href="#" class="list-group-item">Notificaciones</a>
            <a href="#" class="list-group-item">Logout</a>
          </div>
        </div>

        <div class="col-sm-8">
          @yield('content')
        </div>
    </div>
  </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
