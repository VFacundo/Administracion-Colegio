@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
<!-- Barra de Busqueda -->
@include('partials.buscador',['section'=>'Notas','tableId'=>'tablaNotas'])
<!-- Barra de Busqueda FIN-->
<div class="col-sm-2"><a class="btn btn-primary" id="btnGuardarNotas" onclick="guardarNotas('primer_trimestre');">Guardar Notas</a></div>
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
</div>

<div class="table-responsive" style="margin-top:20px;">

<table class="table-sm table-bordered stripe hover display compact cell-border" id="tablaNotas">
  <thead>
  <tr>
    <td rowspan="3">Apellido y Nombre</td>
    <td colspan="4">1er Trimestre</td>
    <td colspan="4">2do Trimestre</td>
    <td colspan="4">3er Trimestre</td>
    <td rowspan="3">Calif. Anual</td>
  </tr>
  <tr>
    <td colspan="3">C. Parciales</td>
    <td rowspan="2">TRIM.</td>
    <td colspan="3">C. Parciales</td>
    <td rowspan="2">TRIM.</td>
    <td colspan="3">C. Parciales</td>
    <td rowspan="2">TRIM.</td>
  </tr>
  <tr>
    <td>Esc.</td>
    <td>Des.</td>
    <td>Otr.</td>
    <td>Esc.</td>
    <td>Des.</td>
    <td>Otr.</td>
    <td>Esc.</td>
    <td>Des.</td>
    <td>Otr.</td>
  </tr>
  </thead>

  <tbody id="notasAlumnos">

    @foreach($alumnos as $alumno)
    <tr id="{{$alumno->id_alumno}}">
      <td>{{$alumno->nombre_persona}} {{$alumno->apellido_persona}}</td>
      <!--PRIMER TRIMESTRE-->
      <td class="primer_trimestre"><input name="evaluacion" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="primer_trimestre"><input name="concepto" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="primer_trimestre"><input name="tp" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="primer_trimestre"><input name="nota" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <!--SEGUNDO TRIMESTRE-->
      <td class="segundo_trimestre"><input name="evaluacion" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="segundo_trimestre"><input name="concepto" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="segundo_trimestre"><input name="tp" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="segundo_trimestre"><input name="nota" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <!--TERCER TRIMESTRE-->
      <td class="tercer_trimestre"><input name="evaluacion" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="tercer_trimestre"><input name="concepto" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="tercer_trimestre"><input name="tp" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>
      <td class="tercer_trimestre"><input name="nota" min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2"></td>

      <td id="notaFinal"><input min="1" max="10" style="max-width:3em;" type="number" maxlenght="2" size="2" disabled></td>
    </tr>
    @endforeach

    <script type="text/javascript">
      window.onload = function(){
        $('#tablaNotas').DataTable().page.len(50).draw();
        disabledNotas("primer_trimestre");
      }
    </script>
  </tbody>
</table>

</div>
@endsection
