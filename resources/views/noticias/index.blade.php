@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
<!-- Barra de Busqueda -->
  @include('partials.buscador',['section'=>'Noticias','tableId'=>'tablaNoticias'])
<!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Noticia</a></div>
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
<div class="container-fluid">
<table id="tablaNoticias" class="display">
  <thead>
    <th>Noticias</th>
  </thead>
  <tbody>
@foreach($noticias as $noticia)
<tr>
  <td>
  <div class="card card-body bg-light mt-3">
      <div class="media">
        	<a class="pull-left" href="#"><img class="mr-3 img-thumbnail imgNoticias" src="{{ asset('/img/noticias.png') }}"></a>
    		<div class="media-body">
          <div class="col-md-9">
          <div class="media-heading d-flex justify-content-md-center">
      		    <h4 class="align-self-center" style="float: left;">{{$noticia->titulo_noticia}}</h4><br>
          </div>
          </div>
            <div class="col-md-3 text-center" style="float: right;">
              <p class="text-lg-right" id="autorNoticia" title="Autor">Autor: {{$noticia->persona_asociada}}</p>
              <div class="col-sm-2 d-inline" style="float: right;">
                <a id="btnUpdate" data-value="{{$noticia->id}}" onclick="editRow();activarEmergente('emergenteUpdate');updateNoticia();" title="Editar" class="btn btn-primary glyphicon glyphicon-pencil"></a>
                <a class="btn btn-danger mt-1 glyphicon glyphicon-trash" title="Eliminar" onclick="deleteRow();confirmDestroyModalNoBody('{{$noticia->id}}','eliminarNoticia','noticias')"></a>
              </div>
            </div>
            <p>{{$noticia->descripcion_noticia}}</p>
            <ul class="list-inline list-unstyled">
    			      <li class="list-inline-item"><span id="fechaNoticia"><i class="glyphicon glyphicon-calendar"></i>{{date("d-m-Y", strtotime($noticia->fecha_origen))}}</span></li>
  			   </ul>
           <!-- style="clear:right" -->
         </div>
      </div>
  </div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection

<style>
.dataTables_wrapper table thead{
    display:none;
    border: none;
    background-color: transparent;
}
table.dataTable.stripe tbody tr.odd, table.dataTable.display tbody tr.odd{
  background-color: transparent !important;
    padding:0 !important;
}
table.dataTable.display tbody tr.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd > .sorting_1{
  background-color: transparent !important;
    padding:0 !important;
}
table.dataTable tbody tr{
  background-color: transparent !important;
  padding:0 !important;
}
table.dataTable.display tbody tr.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.even > .sorting_1{
  background-color: transparent !important;
  padding:0 !important;
}
</style>

<!--BLOQUE CREAR NUEVA NOTICIA -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Noticia Nueva
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
      <form id="formCreate" onSubmit="crearNoticia();return false">
        <label for="titulo_noticia">Titulo :</label>
        <input type="text" class="form-control" name="titulo_noticia"/>
        <label for="descripcion_noticia">Descripcion :</label>
        <input type="text" class="form-control" name="descripcion_noticia"/>

        <button type="submit" class="btn btn-primary">Crear Noticia</button>
        <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrear');">Cancelar</button>
      </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA NOTICIA -->

<!--BLOQUE EDITAR NOTICIA -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteUpdate">
    <div class="card-header">
      Editar Noticia
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
      <form id="formUpdate" onSubmit="setUpdateNoticia();return false">
        <label for="titulo_noticia">Titulo :</label>
        <input type="text" class="form-control" name="titulo_noticia"/>
        <label for="descripcion_noticia">Descripcion :</label>
        <input type="text" class="form-control" name="descripcion_noticia"/>

        <button type="submit" class="btn btn-primary">Modificar Noticia</button>
        <button type="reset" class="btn btn-primary" onclick="noEditRow();activarEmergente('emergenteUpdate');">Cancelar</button>
      </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE EDITAR NOTICIA -->
