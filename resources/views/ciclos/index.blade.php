@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
  <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Ciclos'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Ciclo Lectivo</a></div>
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
  <table id="tablaCiclos" class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Año</td>
          <td>Nombre</td>
          <td colspan="3">Accion</td>
        </tr>
    </thead>
    <tbody>
      @foreach($ciclos as $ciclo)
       <tr>
            <td>{{$ciclo->id}}</td>
            <td>{{$ciclo->anio}}</td>
            <td>{{$ciclo->nombre}}</td>
            <td><a id="btnUpdate" data-value="{{$ciclo->id}}" onclick="activarEmergente('emergenteUpdate'); updateCiclo(); " class="btn btn-primary">Editar</a></td>
            <td><a data-value="{{$ciclo->id}}" href="{{route('curso.index', $ciclo->id)}}" class= 'btn btn-primary'>Ver Cursos</a></td>
            <td><a data-value="{{$ciclo->id}}" onclick="confirmDestroyCiclo({{ ($ciclo->id )}})" class="btn btn-danger">Eliminar</a></td>
         </tr>
        <tr></tr>
      @endforeach
    </tbody>
  </table>
<div>
@endsection

<!--BLOQUE CREAR NUEVA CICLO LECTIVO-->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Nuevo Ciclo Lectivo
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
        <form method="post" onSubmit="return false;" id="formAltaCiclo">
                @csrf
                <label for="anio">Año :</label>
                <input type="text" class="form-control" name="anio" placeholder="Año" required/></textarea>

            <button type="submit" class="btn btn-primary" onclick="crearCiclo();">Crear Ciclo Lectivo</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrear');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA PERSONA -->



<!--BLOQUE EDITAR CICLO -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdate'>
    <div class="card-header">
      Editar Ciclo Lectivo
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
                <label for="anio">Año :</label>
                <input type="text" disable class="form-control" name="anio"/>

            <button type="submit" class="btn btn-primary" onclick="setUpdateCiclo();">Modificar Ciclo Lectivo</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR CICLO -->
