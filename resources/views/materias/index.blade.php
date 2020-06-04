@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="row">
  <div class="col-sm-10"><h3>Materias</h3></div>
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
  <table class="table table-striped" id="tablaPersonas">
    <thead>
        <tr>
          <td>ID</td>
          <td>Nombre</td>
          <td>Carga Horaria</td>
          <td>Titular</td>
          <td>Suplente</td>
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
            <td></td>
            <td></td>
            <td>{{$materia->curso_correspondiente}}</td>
            
            <td><a id="btnUpdate" data-value="{{ ($materia->id )}}" onclick="activarEmergente('emergenteUpdate'); updatePersona()" class="btn btn-primary">Editar</a></td>
            <td><a data-value="{{ ($materia->id )}}" onclick="confirmDestroy({{ ($materia->id )}})" class="btn btn-danger">Eliminar</a></td>
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

                <label for="nombre">Carga horaria semanal :</label>
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

            <button type="submit" class="btn btn-primary" onclick="CrearMateria();">Crear Materia</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrearMateria');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA PERSONA -->

<!--BLOQUE CREAR NUEVA MATERIA -->
<div class="padreEmergente">
  <div class="emergente" id="emergentePaso2">
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
        <form method="post" onSubmit="return false;" id="formCrearCurso2">
                
                @csrf
                <label for="dias">Dias :</label>
                <select name="hora_inicio" style= "border-radius: 5px; height: 30px;">
                   <option value="lunes"> Lunes </option>
                   <option value="martes"> Martes </option>
                   <option value="miercoles"> Miercoles</option>
                   <option value="jueves"> Jueves </option>
                   <option value="viernes"> Viernes</option>
                </select>

                <label for="hora_inicio">Hora Inicio :</label>
                <select name="hora_inicio" style= "border-radius: 5px; height: 30px;">
                   <option value= "13">13:00</option>
                   <option value= "14">14:00</option>
                   <option value= "15">15:10</option>
                   <option value= "16">16:10</option>
                   <option value= "17">17:15</option>
                </select>

                <label for="hora_fin">Hora Fin :</label>
                <select name="hora_fin" style= "border-radius: 5px; height: 30px;">
                   <option value= "14">14:00</option>
                   <option value= "15">15:00</option>
                   <option value= "16">16:10</option>
                   <option value= "17">17:10</option>
                   <option value= "18">18:15</option>
                </select>

            <button type="submit" class="btn btn-primary glyphicon glyphicon-plus" id="btn_mas" onclick="agregarHorario();"></button></p>

            <button type="submit" class="btn btn-primary" id="btn_siguiente" onclick="activarEmergente('emergentePaso3');">Siguiente</button>
            <button type="reset" class="btn btn-primary" id="btn_anterior" onclick="activarEmergente('emergentePaso2');">Anterior</button>
            <button type="reset" class="btn btn-primary" id="btn_cancelar" onclick="activarEmergente('emergentePaso2');">Cancelar</button>

        </form>
    </div>
  </div>
</div>