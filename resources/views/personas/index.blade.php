@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="row">
  <div class="col-sm-8"><h3>Usuarios</h3></div>
  <div class="col-sm-3"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Persona</a></div>
</div>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div><br/>
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Legajo</td>
          <td>Nombre</td>
          <td>Apellido</td>
          <td>DNI</td>
          <td>Domicilio</td>
          <td>Fecha Nacimiento</td>
          <td>Numero Telefono</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($personas as $persona)
        <tr>
            <td>{{$persona->id}}</td>
            <td>{{$persona->legajo}}</td>
            <td>{{$persona->nombre_persona}}</td>
            <td>{{$persona->apellido_persona}}</td>
            <td>{{$persona->dni_persona}}</td>
            <td>{{$persona->domicilio}}</td>
            <td>{{$persona->fecha_nacimiento}}</td>
            <td>{{$persona->numero_telefono}}</td>
            <td><a id="btnUpdate" data-value="{{ ($persona->id )}}" onclick="activarEmergente('emergenteUpdate'); updateUser()" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('personas.destroy', $persona->id)}}" method="post">
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
        <form method="post" action="{{ route('personas.store') }}">

                @csrf
                <label for="legajo">Legajo :</label>
                <input type="text" class="form-control" name="legajo" placeholder="Legajo Persona" required/></textarea>

                <label for="nombre_persona">Nombre :</label>
                <input type="text" class="form-control" name="nombre_persona" placeholder="Nombre Persona" required/></textarea>

                <label for="apellido_persona">Apellido :</label>
                <input type="text" class="form-control" name="apellido_persona" placeholder="Apellido Persona" required/></textarea>

                <label for="dni_persona">DNI :</label>
                <input type="text" class="form-control" name="dni_persona" placeholder="DNI Persona" required/></textarea>

                <label for="domicilio">Domicilio :</label>
                <input type="text" class="form-control" name="domicilio" placeholder="Domicilio Persona" required/></textarea>

                <label for="fecha_nacimiento">Fecha Nacimiento :</label>
                <input type="date" class="form-control" name="fecha_nacimiento" max="<?php echo date("Y") . '-12' . '-31' ;?>" placeholder="Fecha Nacimiento Persona" required/></textarea>

                <label for="numero_telefono">Telefono :</label>
                <input type="text" class="form-control" name="numero_telefono" placeholder="Telefono Persona (Codigo de Area Sin 0 + Numero Sin 15)" pattern="[0-9]{4}-[0-9]{6}" required/></textarea>

            <button type="submit" class="btn btn-primary">Crear Persona</button>
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
                <input type="text" class="form-control" name="id_persona""/>

            <button type="submit" class="btn btn-primary" onclick="setUpdateUser();">Modificar Usuario</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR USUARIO -->
