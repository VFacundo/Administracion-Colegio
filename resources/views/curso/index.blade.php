@extends('layout')

@section('content')
<div class="d-flex flex-row table-before-row">
  <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Ciclo Lectivo' . " " . $ciclo[0]['anio'],'tableId'=>'null'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-auto" style="left:-50px;">
    <a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrearCurso');">Crear Curso</a>
    <?php
      if ($ciclo[0]['estado'] == "inicial" ):
       $nombre = "Cerrar 1er trimestre";
      elseif ($ciclo[0]['estado'] == "primer_trimestre"):
        $nombre = "Cerrar 2do trimestre";
      elseif ($ciclo[0]['estado'] == "segundo_trimestre"):
        $nombre = "Cerrar 3do trimestre";
      elseif ($ciclo[0]['estado'] == "tercer_trimestre"):
        $nombre = "Cerrar Ciclo Lectivo";
      elseif ($ciclo[0]['estado'] == "finalizado"):
        $nombre = "Finalizado";
      endif;

      echo '<a class="btn btn-primary" id="btnEstado" onclick="cambiarEstado('.$ciclo[0]['id'].')">'.$nombre.'</a>';

    ?>
  </div>
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
          <!--BLOQUE MOSTRAR CURSOS-->
          @foreach ($cursos as $curso)
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="heading{{$curso->nombre_curso}}{{$curso->division}}">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->nombre_curso}}{{$curso->division}}" aria-expanded="false" aria-controls="collapseTwo">
                    {{$curso->nombre_curso}} {{$curso->division}}
                  </button>
                </h5>
              </div>
            <div id="collapse{{$curso->nombre_curso}}{{$curso->division}}" class="collapse" aria-labelledby="heading{{$curso->nombre_curso}}{{$curso->division}}" data-parent="#accordion">
              <div class="card-body">
                <!--BLOQUE MOSTRAR MATERIAS DEL CURSO-->
                  <div id="accordion2">
                      <div class="card">
                        <div class="card-header" id="heading{{$curso->nombre_curso}}">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->nombre_curso}}" aria-expanded="false" aria-controls="collapse">
                              Materias
                            </button>
                              <a data-value="{{$curso->nombre_curso}}" onclick="activarEmergente('emergenteAgregarMateria'); listarMaterias({{$curso->id}});" style="width: 150px; position: absolute; right: 30px; top: 10px; color: white;"class="btn btn-primary agregarMaterias">Agregar materia</a>

                          </h5>
                        </div>
                      <div id="collapse{{$curso->nombre_curso}}" class="collapse" aria-labelledby="heading{{$curso->nombre_curso}}" data-parent="#accordion2">
                          <div class="card-body">
                          <script>
                            $(document).ready(function() {
                                $('#tablaMaterias{{$curso->id}}').DataTable({
                                       "oLanguage": {
                                       "sSearch": "Buscar",
                                       "sInfo": "Se muestran de _START_ a _END_ de _TOTAL_ Materias",
                                       "sZeroRecords": "No se encontraron Resultados",
                                       "sInfoEmpty": "No se encontraron Registros para Mostrar",
                                       "oPaginate": {
                                           "sNext": "Siguiente",
                                           "sPrevious": "Anterior"
                                        },
                                        }
                                });
                                $('.dataTables_filter').show();
                              });
                            </script>
                             <table id="tablaMaterias{{$curso->id}}" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <th>Nombre</th>
                                        <th>Carga horaria semanal</th>
                                        <th>Titular</th>
                                        <th>Suplente</th>
                                        <th colspan="1">Accion</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['materias_curso'] as $materia_curso)
                                      <tr>
                                          <td>{{$materia_curso->nombre}}</td>
                                          <td>{{$materia_curso->carga_horaria}} HS</td>

                                          <?php
                                          $i = 0;
                                          foreach ($curso['personal_materias'] as $personal_materia):

                                          if (($materia_curso->nombre) == ($personal_materia->nombre)):
                                              if($personal_materia->tipo == 'titular'):
                                                echo  "<td>$personal_materia->nombre_persona $personal_materia->apellido_persona</td>";
                                                $i ++;
                                              elseif($personal_materia->tipo == 'suplente'):
                                                if ($i == 0):
                                                  echo "<td></td>";
                                                  $i = 2;
                                                endif;
                                                $i++;
                                                echo  "<td>$personal_materia->nombre_persona $personal_materia->apellido_persona</td>";
                                              endif;
                                          endif;

                                          endforeach;
                                          if ($i == 0):
                                                  echo "<td></td>";
                                                  echo "<td></td>";
                                          elseif ($i == 1):
                                                  echo "<td></td>";
                                          endif;
                                          ?>

                                          <td>
                                            <a  onclick="activarEmergente('emergenteAsignarDocente'); listarPersonalDocente('{{$curso->id}}','{{$materia_curso->id}}')" style="color:white;"class="btn btn-primary">Asignar docente</a>
                                            <a  onclick="controlarHorario('{{$curso->id}}','{{$materia_curso->id}}')" style="color:white;"class="btn btn-primary">Asignar horario</a>
                                            <a  onclick="confirmDestroyMateriaCurso('{{$curso->id}}','{{$materia_curso->id}}')" style="color:white;"class="btn btn-danger eliminarMateria">Eliminar</a>
                                          </td>
                                       </tr>

                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                        <th>Nombre</th>
                                        <th>Carga horaria semanal</th>
                                        <th>Titular</th>
                                        <th>Suplente</th>
                                        <th>Accion</th>
                                      </tr>
                                  </tfoot>
                             </table>
                          </div>
                      </div>
                      </div>
                  </div>
                <!--BLOQUE MOSTRAR ALUMNOS DEL CURSO-->
                   <div id="accordion3">
                      <div class="card">
                        <div class="card-header" id="heading{{$curso->nombre_curso}}{{$curso->id}}">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->nombre_curso}}{{$curso->id}}" aria-expanded="false" aria-controls="collapse">
                              Alumnos
                            </button>
                              <a data-value="{{$curso->id}}" onclick="activarEmergente('emergenteAgregarAlumno'); listarAlumnos({{$curso->id}}, {{$ciclo[0]->anio}});" style="width: 150px; position: absolute; right: 30px; top: 10px; color: white;"class="btn btn-primary">Agregar alumno</a>

                          </h5>
                        </div>
                      <div id="collapse{{$curso->nombre_curso}}{{$curso->id}}" class="collapse" aria-labelledby="heading{{$curso->nombre_curso}}{{$curso->id}}" data-parent="#accordion3">
                          <div class="card-body">
                            <script>
                            $(document).ready(function() {
                                $('#tablaAlumnos{{$curso->id}}').DataTable({
                                       "oLanguage": {
                                       "sSearch": "Buscar",
                                       "sInfo": "Se muestran de _START_ a _END_ de _TOTAL_ Alumnos",
                                       "sZeroRecords": "No se encontraron Resultados",
                                       "sInfoEmpty": "No se encontraron Registros para Mostrar",
                                       "oPaginate": {
                                           "sNext": "Siguiente",
                                           "sPrevious": "Anterior"
                                        },
                                        }
                                });
                                $('.dataTables_filter').show();
                            });
                            </script>
                               <table id="tablaAlumnos{{$curso->id}}" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <th>Legajo</th>
                                        <th>Nombre y apellido</th>
                                        <th>Numero de documento</th>
                                        <th>Accion</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['alumnos_curso'] as $alumno_curso)
                                      <tr>
                                          <td>{{$alumno_curso->legajo_alumno}}</td>
                                          <td>{{$alumno_curso->nombre_persona}} {{$alumno_curso->apellido_persona}}</td>
                                          <td>{{$alumno_curso->dni_persona}}</td>
                                          <td><a data-value="" onclick="confirmDestroyAlumnoCurso('{{$alumno_curso->id}}','{{$alumno_curso->persona_asociada}}','{{$alumno_curso->id_curso}}')" style="color:white;"class="btn btn-danger">Eliminar del curso</a></td>
                                       </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                        <th>Legajo</th>
                                        <th>Nombre y apellido</th>
                                        <th>Numero de documento</th>
                                        <th>Accion</th>
                                      </tr>
                                  </tfoot>
                             </table>
                          </div>
                      </div>
                      </div>
                  </div>
                  <!--BLOQUE MOSTRAR PRECEPTORES DEL CURSO-->
                     <div id="accordion5">
                        <div class="card">
                          <div class="card-header" id="heading{{$curso->id}}{{$curso->nombre_curso}}">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->id}}{{$curso->nombre_curso}}" aria-expanded="false" aria-controls="collapse">
                               Preceptor
                              </button>
                              <a data-value="" onclick="activarEmergente('emergenteAgregarPreceptor'); listarPersonalPreceptor({{$curso->id}})" style="position: absolute; right: 30px; top: 10px; color: white; width: 150px;"class="btn btn-primary">Agregar preceptor</a>

                            </h5>
                          </div>
                        <div id="collapse{{$curso->id}}{{$curso->nombre_curso}}" class="collapse" aria-labelledby="heading{{$curso->id}}{{$curso->nombre_curso}}" data-parent="#accordion5">
                            <div class="card-body">
                              <table id="tablaPreceptor" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <td>Legajo</td>
                                        <td>Nombre y apellido</td>
                                        <td>Numero de documento</td>
                                        <td colspan="1">Accion</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['preceptores_curso'] as $preceptor_curso)
                                      <tr>
                                          <td>{{$preceptor_curso->legajo_personal}}</td>
                                          <td>{{$preceptor_curso->nombre_persona}} {{$preceptor_curso->apellido_persona}}</td>
                                          <td>{{$preceptor_curso->dni_persona}}</td>
                                          <td><a data-value="" onclick="" style="color:white;"class="btn btn-danger">Eliminar</a></td>
                                       </tr>
                                      <tr></tr>
                                    @endforeach
                                  </tbody>
                             </table>
                            </div>
                        </div>
                        </div>
                    </div>
              </div>
            </div>
            </div>
          </div>
        @endforeach
      <script type="text/javascript">
        window.onload = function(){
        disabledBotones("{{$ciclo[0]['estado']}}");
      }
    </script>


<div>
@endsection


<!--BLOQUE AGREGAR MATERIA A CURSO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteAgregarMateria">
    <div class="card-header">
      Agregar Materia
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
        <form method="post" onSubmit="return false;" id="formAsignarMateria">

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                @csrf


        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE AGREGAR MATERIA A CURSO -->


<!--BLOQUE AGREGAR ALUMNO A CURSO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteAgregarAlumno">
    <div class="card-header">
      Agregar Alumno
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
        <form method="post" onSubmit="return false;" id="formAsignarAlumno">
                @csrf

        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE AGREGAR ALUMNO A CURSO -->


<!--BLOQUE AGREGAR CURSO CICLO LECTIVO-->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrearCurso">
    <div class="card-header">
      Agregar Curso al Ciclo Lectivo
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
        <form method="post" onSubmit="return false;" id="formAgregarCursoCiclo">
                @csrf

                <label for="curso">Curso :</label>
                <select name="curso" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "Primero">Primero</option>
                   <option value= "Segundo">Segundo</option>
                   <option value= "Tercero">Tercero</option>
                   <option value= "Cuarto">Cuarto</option>
                   <option value= "Quinto">Quinto</option>
                   <option value= "Sexto">Sexto</option>
                </select></p>

                <label for="division">Division :</label>
                <select name="division" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "A">A</option>
                   <option value= "B">B</option>
                </select></p>

                <label for="aula">Aula :</label>
                <select name="aula" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">
                   <option value= "1">1</option>
                   <option value= "2">2</option>
                   <option value= "3">3</option>
                   <option value= "4">4</option>
                   <option value= "5">5</option>
                   <option value= "6">6</option>
                   <option value= "7">7</option>
                   <option value= "8">8</option>
                   <option value= "9">9</option>
                   <option value= "10">10</option>
                </select></p>



            <button type="submit" class="btn btn-primary" onclick="agregarCursoCiclo({{$ciclo[0]}});">Agregar Curso </button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrearCurso');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE AGREGAR CURSO CICLO LECTIVO -->

<!--BLOQUE AGREGAR PRECEPTOR A CURSO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteAgregarPreceptor">
    <div class="card-header">
      Agregar Preceptor
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
        <form method="post" onSubmit="return false;" id="formAsignarPreceptor">
                @csrf
                <label for="Preceptor">Preceptor :</label>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE AGREGAR PRECEPTOR A CURSO -->

<!--BLOQUE ASIGNAR HORARIO A MATERIA -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteAsignarHorario">
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
        <form method="post" onSubmit="return false;" id="formAsignarHorario">

                @csrf


        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE ASIGNAR HORARIO A MATERIA -->

<!--BLOQUE AGREGAR ALUMNO A CURSO -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteAsignarDocente">
    <div class="card-header">
      Asignar Docente
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
        <form method="post" onSubmit="return false;" id="formAsignarDocente">
                @csrf

        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE AGREGAR ALUMNO A CURSO -->
