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
  <div class="table-responsive">
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>UserName</td>
          <td>EMail</td>
          <td>Persona</td>
          <td>Roles</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($usuariosRegistrados as $user)
        <tr id="userTable">
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td><a href="#" onClick="return false;">{{$user->persona}}</a></td>
            <td>
              @foreach($user['rolesUser'] as $roles)
                {{$roles->nombre_rol}} <br>
              @endforeach
            </td>
            <td><a id="btnUpdate" data-value="{{ ($user->id )}}" onclick="activarEmergente('emergenteUpdate'); updateUser()" class="btn btn-primary">Editar</a></td>
            <td>
              <a class="btn btn-danger" onclick="confirmDestroyModal({{$user->id}},'eliminarRegistro','usuarios')">Eliminar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <div>
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
        <form method="post" onSubmit="return false;" id="formAltaUser">

                @csrf
                <label for="name">Username :</label>
                <input type="text" class="form-control" name="name"/></textarea>

                <label for="password">Password :</label>
                <input type="Password" class="form-control" name="password"/>

                <label for="email">EMail :</label>
                <input type="text" class="form-control" name="email"/>

                <label for="id_persona">id_persona :</label>
                <input type="text" class="form-control" name="id_persona"/>

                <label for="roles_box">Roles :</label>
                <div style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                  @foreach($rolesT as $rolT)
                    <input type="checkbox" name="roles_box" value="{{($rolT->nombre_rol)}}">
                    <label for="roles_box">{{($rolT->nombre_rol)}}</label><br>
                  @endforeach
                </div>
            <button type="submit" class="btn btn-primary" onclick="crearUser();">Crear Usuario</button>
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
        <form id="formUpdate" onSubmit="return false;">

                @csrf
                <label for="name">Username :</label>
                <input type="text" class="form-control" name="name"/></textarea>

                <label for="email">EMail :</label>
                <input type="text" class="form-control" name="email"/>

                <label for="id_persona">id_persona :</label>
                <input type="text" class="form-control" name="id_persona"/>

                <label for="roles_box">Roles :</label>
                <div style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                  @foreach($rolesT as $rolT)
                    <input type="checkbox" name="roles_box" value="{{($rolT->nombre_rol)}}">
                    <label for="roles_box">{{($rolT->nombre_rol)}}</label><br>
                  @endforeach
                </div>

            <button type="submit" class="btn btn-primary" onclick="setUpdateUser();">Modificar Usuario</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR USUARIO -->
