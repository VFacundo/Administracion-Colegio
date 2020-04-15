<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sistema Administracion Colegio</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>

  <div class="jumbotron text-center">
    <h1>Sistema de Administracion</h1>
    <p>-Colegio Nro 2 Rawson-</p>
  </div>

  <div class="container">
      <div class="row justify-content-center">
      <style>
        .uper {
          margin-top: 40px;
        }
      </style>
      <div class="card uper">
        <div class="card-header">
          Sistema de Administracion de Colegio
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
              </ul>
            </div><br />
          @endif
            <form method="post" action="{{ route('usuarios.index') }}">
                <div class="form-group">
                    @csrf
                    <label for="username">Nombre de Usuario: </label>
                    <input type="text" class="form-control" name="username"/>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña: </label>
                    <input type="password" class="form-control" name="password"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
