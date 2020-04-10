@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="row">
  <div class="col-sm-8"><h3>Usuarios</h3></div>
  <div class="col-sm-3"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Usuarios</a></div>
</div>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Legajo</td>
          <td>UserName</td>
          <td>Mail</td>
          <td>Id_Persona</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($usuariosRegistrados as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->legajo}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->mail}}</td>
            <td>{{$user->id_persona}}</td>
            <td><a id="btnUpdate" data-value="{{ ($user->id )}}" onclick="activarEmergente('emergenteUpdate'); updateUser()" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('usuarios.destroy', $user->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection

<!--BLOQUE CREAR NUEVO USUARIO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
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
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrear');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVO USUARIO -->

<!--BLOQUE EDITAR USUARIO -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdate'>
    <div class="card-header">
      Editar Usuario
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
        <form method="post" action="" id="formUpdate">

                @csrf
                <label for="legajo">Legajo:</label>
                <input type="text" class="form-control" name="legajo"/>

                <label for="username">Username :</label>
                <input type="text" class="form-control" name="username"/></textarea>

                <label for="Mail">Mail :</label>
                <input type="text" class="form-control" name="mail"/>

                <label for="id_persona">id_persona :</label>
                <input type="text" class="form-control" name="id_persona""/>

            <button type="submit" class="btn btn-primary">Modificar Usuario</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR USUARIO -->
