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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{{ asset('js/emergente.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/ajaxData.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataRoles.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataCiclo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataMateria.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataAlumno.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataCurso.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajaxDataPersonal.js') }}"></script>


</head>
<body>
<div class="container container-noMargin divNavbar">
  <!--NAV INICIO -->
  <nav id="navNoti" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container-fluid">
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
                        <span class="glyphicon glyphicon-bell">Notificaciones<span class="badge">{{count(auth()->user()->unreadNotifications)}}</span>
                      </a>
                      <ul class="dropdown-menu" role="menu">
                        <li>
                          @foreach(auth()->user()->unreadNotifications as $notification)
                            <a href="#">{{$notification->data['mensaje']}}</a>
                          @endforeach
                        </li>
                      </ul>
                  </li>

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
  <!--
  <div class="jumbotron text-center">
    <h1>Sistema de Administracion</h1>
    <p>-Colegio Nro 2 Rawson-</p>
  </div>

-->
</div>
<!-- CAROUSEL -->
<div id="carouselColegio" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Patio_Rectorado_de_la_Universidad_Nacional_de_Córdoba.JPG" class="d-block w-100 img-fluid" alt="...">
    </div>

    <div class="carousel-item">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Escuela_766_Perito_Moreno.jpg" class="d-block w-100 img-fluid" alt="...">
    </div>

  </div>

  <div class="carousel-caption d-none d-md-block">
    <h3>Sistema de Administracion</h3>
    <p>-Colegio Nro 2 Rawson-</p>
  </div>
  <a class="carousel-control-prev" href="#carouselColegio" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselColegio" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <div class="div-btn-menu"><button class="boton-menu glyphicon glyphicon-chevron-down" onclick="mostrarMenu();"></button></div>
</div>
<!-- CAROUSEL FIN -->

  <div class="container-fluid">
    <div class="row">

      <!--NAV INICIO MENU-->
      <div class="col-2 nav-menu">
        <div class="list-group">
            <a href="{{route('personas.index')}}" class="list-group-item">Personas</a>
            <a href="{{route('usuarios.index')}}" class="list-group-item">Usuarios</a>
            <a href="{{route('roles.index')}}" class="list-group-item">Roles y Permisos</a>
            <a href="{{route('ciclo.index')}}" class="list-group-item">Ciclo Lectivo</a>
            <a href="{{route('materia.index')}}" class="list-group-item">Materias</a>
            <a href="{{route('alumno.index')}}" class="list-group-item">Alumnos</a>
            <a href="{{route('personal.index')}}" class="list-group-item">Personal</a>
            <a href="#" class="list-group-item">Noticias</a>
            <a href="#" class="list-group-item">Notificaciones</a>
          </div>
        </div>
      <!-- NAV FIN -->

        <div class="col-10" id="cuerpo-tabla">
          <div class="tab-content" id="nav-tabContent">
          @yield('content')
        </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!--Si la res es menor a 1000px la tabla ocupa toda la pantalla-->
        <script>
        $(document).ready(function(){
          var win = $(this);
          $(document).keyup(function(e) {
            if (e.key === "Escape") { // escape key maps to keycode `27`
              if($('.emergenteActiva').length != 0){
                activarEmergente($('.emergenteActiva')[0].id);
              }
            }
            });
            
          if (win.width() < 1000) {
            $('#cuerpo-tabla').addClass('col-12');
            $('#cuerpo-tabla').removeClass('col-10');
          }
        });
        </script>

        <!--Si la res cambia a menor 1000px la tabla ocupa toda la pantalla-->
        <script>
        $(window).on('resize', function() {
          var win = $(this);
          if (win.width() > 1000) {
            $('#cuerpo-tabla').addClass('col-10');
            $('#cuerpo-tabla').removeClass('col-12');
          } else {
            $('#cuerpo-tabla').addClass('col-12');
            $('#cuerpo-tabla').removeClass('col-10');
          }
          });
        </script>

        <script>
        function mostrarMenu(){
          var menu = document.getElementsByClassName("nav-menu")[0], btn = event.target;
          if(menu.style.display == "flex"){
            menu.style.display="none";
            btn.classList.remove("glyphicon-chevron-up");
            btn.classList.add("glyphicon-chevron-down");
          }else{
            menu.style.display="flex";
            menu.style.position="absolute";
            btn.classList.remove("glyphicon-chevron-down");
            btn.classList.add("glyphicon-chevron-up");
          }
        }
        </script>

    </div>
  </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
