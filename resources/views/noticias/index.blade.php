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
    <th> </th>
  </thead>
  <tbody>
@foreach($noticias as $noticia)
<tr>
  <td>
  <div class="card card-body bg-light mt-3">
      <div class="media">
        	<a class="pull-left" href="#"><img class="mr-3 img-thumbnail imgNoticias" src="{{ asset('/img/noticias.png') }}"></a>
    		<div class="media-body">
          <div class="media-heading">
      		<h4 style="float: left;">{{$noticia->titulo_noticia}}</h4>
            <p class="text-lg-right" style="float: right;">Autor: {{$noticia->persona_asociada}}</p></div>
            <p style="clear:right">
              {{$noticia->descripcion_noticia}}
            </p>
            <ul class="list-inline list-unstyled">
    			      <li class="list-inline-item"><span><i class="glyphicon glyphicon-calendar"></i>{{date("d-m-Y", strtotime($noticia->fecha_origen))}}</span></li>
  			   </ul>
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
      <label for="titulo_noticia">Titulo :</label>
      <input type="text" class="form-control" name="titulo_noticia"/>
      <label for="descripcion_noticia">Descripcion :</label>
      <input type="text" class="form-control" name="descripcion_noticia"/>

      <button type="submit" class="btn btn-primary" onclick="setUpdatePersona();">Crear Noticia</button>
      <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrear');">Cancelar</button>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVA NOTICIA -->
