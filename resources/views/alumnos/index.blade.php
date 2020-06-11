@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
  <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Alumnos'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear'); listarCrearAlumno();">Crear Alumno</a></div>
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
  <table class="table table-striped" id="tablaAlumnos">
    <thead>
        <tr>
          <td>ID</td>
          <td>Nombre</td>
          <td>Apellido</td>
          <td>Legajo</td>
          <td>Responsable</td>
          <td>Promedio</td>
          <td>Asistencias</td>
          <td colspan="2">Accion</td>
        </tr>
    </thead>
    <script>
      $(document).ready(function(){
          $('[data-toggle="popover"]').popover();
      });
    </script>
    <tbody>
        @foreach($alumnos as $alumno)
        <tr>
            <td>{{$alumno->id}}</td>
            <td>{{$alumno->nombrePersona}}</td>
            <td>{{$alumno->apellidoPersona}}</td>
            <td>{{$alumno->legajo_alumno}}</td>
            <td><a href="#" onClick="return false;" title="Persona" data-toggle="popover" data-trigger="hover" data-html="true" data-content="{{$alumno->personaString}}">{{$alumno->persona}}</a></td>
            <td>Promedio</td>
            <td>Asistencias</td>
            <td><a id="btnUpdate" data-value="{{ ($alumno->id )}}" onclick="activarEmergente('emergenteUpdateAlumno'); updateAlumno()" class="btn btn-primary">Editar</a></td>
            <td><a data-value="{{ ($alumno->id )}}" onclick="confirmDestroyAlumno({{ ($alumno->id )}})" class="btn btn-danger">Eliminar</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div>
<div>
@endsection

<!--BLOQUE CREAR NUEVO ALUMNO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Alumno
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
        <form method="post" onSubmit="return false;" id="formCrearAlumno">  
              
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA PERSONA -->

<!--BLOQUE EDITAR ALUMNO -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdateAlumno'>
    <div class="card-header">
      Editar Alumno
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
        <form id="formUpdateAlumno" onSubmit="return false;">

                @csrf
                <label for="legajo_alumno">Legajo :</label>
                <input type="text" class="form-control" name="legajo_alumno" placeholder="Legajo del alumno. Numero de 6 digitos entre 0 y 099.999" required/></textarea>

                <label for="persona_tutor">Responsable :</label>
                <select name="persona_tutor" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                @foreach($personas_tutor as $persona_tutor)
                   <option value= "{{$persona_tutor->id}}">{{$persona_tutor->nombre_persona}} {{$persona_tutor->apellido_persona}}</option>
                @endforeach
                </select></p>

            <button type="submit" class="btn btn-primary" onclick="setUpdateAlumno();">Modificar Alumno</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdateAlumno');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR ALUMNO -->
