@extends('layout')

@section('content')

<div class="d-flex flex-row table-before-row">
<!-- Barra de Busqueda -->
@include('partials.buscador',['section'=>'Personas'])
<!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Persona</a></div>
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
  <div class="table-responsive">
  <table class="table table-striped" id="tablaPersonas">
    <thead>
        <tr>
          <td>ID</td>
          <td>Legajo</td>
          <td>Nombre</td>
          <td>Apellido</td>
          <td>Tipo de documento</td>
          <td>Número de documento</td>
          <td>CUIL</td>
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
            <td>{{$persona->tipo_documento}}</td>
            <td>{{$persona->dni_persona}}</td>
            <td>{{$persona->cuil_persona}}</td>
            <td>{{$persona->domicilio}}</td>
            <td>{{$persona->fecha_nacimiento}}</td>
            <td>{{$persona->numero_telefono}}</td>
            <td><a id="btnUpdate" data-value="{{ ($persona->id )}}" onclick="activarEmergente('emergenteUpdate'); updatePersona()" class="btn btn-primary">Editar</a></td>
            <td><a data-value="{{ ($persona->id )}}" onclick="confirmDestroy({{ ($persona->id )}})" class="btn btn-danger">Eliminar</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <div>
<div>
@endsection

<!--BLOQUE CREAR NUEVA PERSONA -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Persona Nueva
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

                <label for="tipo_documento">Tipo Documento :</label>
                <select name="tipo_documento" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                @foreach($tipo_documento as $tipo_doc)
                   <option value= "{{$tipo_doc->id}}">{{$tipo_doc->nombre_tipo}}</option>
                @endforeach
                </select></p>

                <label for="dni_persona">Número de documento :</label>
                <input type="text" class="form-control" name="dni_persona" placeholder="DNI Persona" required/></textarea>

                <label for="cuil_persona">Número de CUIL :</label>
                <input type="text" class="form-control" name="cuil_persona" placeholder="CUIL Persona" required/></textarea>


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

<!--FIN BLOQUE CREAR NUEVA PERSONA -->

<!--BLOQUE EDITAR PERSONA -->
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
                <label for="legajo">Legajo :</label>
                <input type="text" class="form-control" name="legajo"/>

                <label for="nombre_persona">Nombre Persona :</label>
                <input type="text" class="form-control" name="nombre_persona"/>

                <label for="apellido_persona">Apellido Persona :</label>
                <input type="text" class="form-control" name="apellido_persona"/>

                <label for="tipo_documento">Tipo Documento :</label>
                <select name="tipo_documento" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                @foreach($tipo_documento as $tipo_doc)
                   <option value= "{{$tipo_doc->id}}">{{$tipo_doc->nombre_tipo}}</option>
                @endforeach
                </select></p>

                <label for="dni_persona">Nùmero de documento :</label>
                <input type="text" class="form-control" name="dni_persona" placeholder="DNI Persona" required/></textarea>

                <label for="cuil_persona">Número de CUIL :</label>
                <input type="text" class="form-control" name="cuil_persona" placeholder="CUIL Persona" required/></textarea>

                <label for="domicilio">Domicilio Persona :</label>
                <input type="text" class="form-control" name="domicilio"/>

                <label for="fecha_nacimiento">Fecha de Nacimiento :</label>
                <input type="date" class="form-control" name="fecha_nacimiento"/>

                <label for="numero_telefono">Numero de Telefono :</label>
                <input type="text" class="form-control" name="numero_telefono"/>

                <label for="estado_persona">Estado :</label>
                <input type="text" class="form-control" name="estado_persona"/>

            <button type="submit" class="btn btn-primary" onclick="setUpdatePersona();">Modificar Persona</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR PERSONA -->
