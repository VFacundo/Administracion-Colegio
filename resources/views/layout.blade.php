<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistema Administracion Colegio</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{{ asset('js/emergente.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/ajaxData.js') }}"></script>
</head>
<body>

  <div class="jumbotron text-center">
    <h1>Sistema de Administracion</h1>
    <p>-Colegio Nro 2 Rawson-</p>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="list-group">
            <a href="#" class="list-group-item">Administracion de Personas</a>
            <a href="#" class="list-group-item">Administracion de Usuarios</a>
            <a href="#" class="list-group-item">Administracion de Roles</a>
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
