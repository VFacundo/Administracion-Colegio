@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<h3>Usuarios</h3>
<div class="card uper">
  <div class="card-header">
    Crear Usuario Nuevo
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
      <form method="post" action="{{ route('usuarios.store') }}">

              @csrf
              <label for="legajo">Legajo:</label>
              <input type="text" class="form-control" name="legajo"/>

              <label for="username">Username :</label>
              <input type="text" class="form-control" name="username"/></textarea>

              <label for="password">Password :</label>
              <input type="Password" class="form-control" name="password"/>

              <label for="Mail">Mail :</label>
              <input type="text" class="form-control" name="mail"/>

              <label for="id_persona">id_persona :</label>
              <input type="text" class="form-control" name="id_persona"/>

          <button type="submit" class="btn btn-primary">Crear Usuario</button>
      </form>
  </div>
</div>
@endsection
