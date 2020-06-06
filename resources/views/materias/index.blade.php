@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
  <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Materias'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrearMateria');">Crear Materia</a></div>
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
  <table class="table table-striped" id="tablaMaterias">
    <thead>
        <tr>
          <td>ID</td>
          <td>Nombre</td>
          <td>Carga Horaria</td>
          <td>Programa Materia</td>
          <td>Estado</td>
          <td>Curso Correspondiente</td>
          <td colspan="2">Accion</td>
        </tr>
    </thead>
    <tbody>
      @foreach($materias as $materia)
        <tr>
            <td>{{$materia->id}}</td>
            <td>{{$materia->nombre}}</td>
            <td>{{$materia->carga_horaria}}</td>
            <td>{{$materia->programa_materia}}</td>
            <td>{{$materia->estado_materia}}</td>
            <td>{{$materia->curso_correspondiente}}</td>
            
            <td><a id="btnUpdate" data-value="{{ ($materia->id )}}" onclick="activarEmergente('emergenteUpdateMateria'); updateMateria()" class="btn btn-primary">Editar</a></td>
            <td><a data-value="{{ ($materia->id )}}" onclick="confirmDestroyMateria({{ ($materia->id )}})" class="btn btn-danger">Eliminar</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div>
<div>
@endsection

<!--BLOQUE CREAR NUEVA MATERIA -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrearMateria">
    <div class="card-header">
      Crear Materia
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
        <form method="post" onSubmit="return false;" id="formCrearMateria">
                
                @csrf
                <label for="nombre">Nombre :</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre materia" required/></textarea>

                <label for="carga_horaria">Carga horaria semanal :</label>
                <input type="text" class="form-control" name="carga_horaria" placeholder="Carga horaria semanal. Ej: 4" required/></textarea>
                
                <label for="curso">Curso :</label>
                <select name="curso" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "Primero">Primero</option>
                   <option value= "Segundo">Segundo</option>
                   <option value= "Tercero">Tercero</option>
                   <option value= "Cuarto">Cuarto</option>
                   <option value= "Quinto">Quinto</option>
                   <option value= "Sexto">Sexto</option>
                </select></p>

                <label for="programa_materia">Programa Materia :</label>
                <select name="programa_materia" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                @foreach($programas as $programa_materia)
                   <option value= "{{$programa_materia->id}}">{{$programa_materia->nombre_archivo}}</option>
                @endforeach
                </select></p>  

            <button type="submit" class="btn btn-primary" onclick="crearMateria();">Crear Materia</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrearMateria');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA PERSONA -->

<!--BLOQUE EDITAR MATERIA -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdateMateria'>
    <div class="card-header">
      Editar Materia
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
        <form id="formUpdateMateria" onSubmit="return false;">

                @csrf
                <label for="nombre">Nombre :</label>
                <input type="text" class="form-control" name="nombre" required/></textarea>

                <label for="carga_horaria">Carga horaria semanal :</label>
                <input type="text" class="form-control" name="carga_horaria"required/></textarea>
                
                <label for="curso">Curso :</label>
                <select name="curso" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "Primero">Primero</option>
                   <option value= "Segundo">Segundo</option>
                   <option value= "Tercero">Tercero</option>
                   <option value= "Cuarto">Cuarto</option>
                   <option value= "Quinto">Quinto</option>
                   <option value= "Sexto">Sexto</option>
                </select></p>

                <label for="estado_materia">Estado :</label>
                <select name="estado_materia" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "activo">Activo</option>
                   <option value= "inactivo">Inactivo</option>
                </select></p>

                <label for="programa_materia">Programa Materia :</label>
                <select name="programa_materia" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                @foreach($programas as $programa_materia)
                   <option value= "{{$programa_materia->id}}">{{$programa_materia->nombre_archivo}}</option>
                @endforeach
                </select></p>  

            <button type="submit" class="btn btn-primary" onclick="setUpdateMateria();">Modificar Materia</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdateMateria');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR MATERIA -->
