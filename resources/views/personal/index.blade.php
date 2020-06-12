@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
  <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Personal','tableId'=>'tablaPersonal'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear'); listarCrearPersonal();">Crear Personal</a></div>
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
  <table class="table cell-border stripe hover" id="tablaPersonal">
    <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Legajo</th>
          <th>Datos personales</th>
          <th>Tipo(Titular/Suplente)</th>
          <th>Fecha alta</th>
          <th>Manejo de grupo</th>
          <th>Accion</th>
        </tr>
    </thead>
    <script>
      $(document).ready(function(){
          $('[data-toggle="popover"]').popover();
      });
    </script>
    <tbody>
         @foreach($personals as $personal)
        <tr>
            <td>{{$personal->id}}</td>
            <td>{{$personal->nombrePersona}}</td>
            <td>{{$personal->apellidoPersona}}</td>
            <td>{{$personal->legajo_personal}}</td>
            <td><a href="#" onClick="return false;" title="Persona" data-toggle="popover" data-trigger="hover" data-html="true" data-content="{{$personal->personaString}}">Ver datos personales</a></td>
            <td> </td>
            <td>{{date("d-m-Y", strtotime($personal->fecha_alta))}}</td>
            <td>{{$personal->manejo_de_grupo}}</td>
            <td>
              <a id="btnUpdate" data-value="{{ ($personal->id )}}" onclick="activarEmergente('emergenteUpdatePersonal'); updatePersonal()" class="btn btn-primary">Editar</a>
              <a data-value="{{ ($personal->id )}}" onclick="confirmDestroyPersonal({{ ($personal->id )}})" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Legajo</th>
          <th>Datos personales</th>
          <th>Tipo(Titular/Suplente)</th>
          <th>Fecha alta</th>
          <th>Manejo de grupo</th>
          <th>Accion</th>
        </tr>
    </tfoot>
  </table>
  <div>
<div>
@endsection

<!--BLOQUE CREAR NUEVO PERSONAL -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Personal
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
        <form method="post" onSubmit="return false;" id="formCrearPersonal">

        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA PERSONA -->

<!--BLOQUE EDITAR PERSONAL -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdatePersonal'>
    <div class="card-header">
      Editar Personal
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
        <form id="formUpdatePersonal" onSubmit="return false;">

                @csrf
                <label for="legajo_personal">Legajo :</label>
                <input type="text" class="form-control" name="legajo_personal" placeholder="Legajo del personal. Numero de 6 digitos entre 100.000 y 200.000" required/></textarea>

                <label for="manejo_de_grupo">Manejo de grupo :</label>
                <select name="manejo_de_grupo" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                    <option value= "Malo">Malo</option>
                    <option value= "Regular">Regular</option>
                    <option value= "Bueno">Bueno</option>
                    <option value= "Excelente">Excelente</option>
                </select></p>;

            <button type="submit" class="btn btn-primary" onclick="setUpdatePersonal();">Modificar Personal</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdatePersonal');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR PERSONAL -->
