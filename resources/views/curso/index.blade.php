@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="row">
  <div class="col-sm-8"><h3>{{($ciclo[0]->nombre)}}</h3></div>
  <div class="col-sm-3"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrearCurso');">Crear Curso</a></div>
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
                              <a data-value="{{$curso->nombre_curso}}" onclick="activarEmergente('emergenteAgregarMateria'); listarMaterias({{$curso->id}});" style="width: 150px; position: absolute; right: 30px; top: 10px; color: white;"class="btn btn-primary">Agregar materia</a>

                          </h5>
                        </div>
                      <div id="collapse{{$curso->nombre_curso}}" class="collapse" aria-labelledby="heading{{$curso->nombre_curso}}" data-parent="#accordion2">
                          <div class="card-body">
                             <table id="tablaPreceptor" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <td>Nombre</td>
                                        <td>Carga horaria semanal</td>
                                        <td colspan="1">Accion</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['materias_curso'] as $materia_curso)
                                      <tr>
                                          <td>{{$materia_curso->nombre}}</td>
                                          <td>{{$materia_curso->carga_horaria}} HS</td>                                        
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
                <!--BLOQUE MOSTRAR ALUMNOS DEL CURSO-->
                   <div id="accordion3">
                      <div class="card">
                        <div class="card-header" id="heading{{$curso->nombre_curso}}{{$curso->id}}">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->nombre_curso}}{{$curso->id}}" aria-expanded="false" aria-controls="collapse">
                              Alumnos 
                            </button>
                              <a data-value="{{$curso->id}}" onclick="activarEmergente('emergenteAgregarAlumno'); listarAlumnos({{$curso->id}});" style="width: 150px; position: absolute; right: 30px; top: 10px; color: white;"class="btn btn-primary">Agregar alumno</a>

                          </h5>
                        </div>
                      <div id="collapse{{$curso->nombre_curso}}{{$curso->id}}" class="collapse" aria-labelledby="heading{{$curso->nombre_curso}}{{$curso->id}}" data-parent="#accordion3">
                          <div class="card-body">                              
                               <table id="tablaAlumnos" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <td>Legajo</td>
                                        <td>Nombre y apellido</td>
                                        <td>Numero de documento</td>
                                        <td colspan="1">Accion</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['alumnos_curso'] as $alumno_curso)
                                      <tr>
                                          <td>{{$alumno_curso->legajo_alumno}}</td>
                                          <td>{{$alumno_curso->nombre_persona}} {{$alumno_curso->apellido_persona}}</td>
                                          <td>{{$alumno_curso->dni_persona}}</td>
                                          <td><a data-value="" onclick="confirmDestroyAlumno('{{$alumno_curso->id}}','{{$alumno_curso->persona_asociada}}','{{$alumno_curso->id_curso}}')" style="color:white;"class="btn btn-danger">Eliminar del curso</a></td>
                                       </tr>
                                      <tr></tr>
                                    @endforeach
                                  </tbody>
                             </table>
                          </div>
                      </div>
                      </div> 
                  </div>
                   <!--BLOQUE MOSTRAR DOCENTES DEL CURSO-->
                     <div id="accordion4">
                        <div class="card">
                          <div class="card-header" id="heading{{$curso->id}}">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->id}}" aria-expanded="false" aria-controls="collapse">
                                Docentes 
                              </button>
                              <a data-value="" onclick="" style="width: 150px; position: absolute; right: 30px; top: 10px; color: white;"class="btn btn-primary">Agregar docente</a>

                            </h5>
                          </div>
                        <div id="collapse{{$curso->id}}" class="collapse" aria-labelledby="heading{{$curso->id}}" data-parent="#accordion4">
                            <div class="card-body">
                                <table id="tablaDocentes" class="table table-striped">
                                  <thead>
                                      <tr>
                                        <td>Legajo</td>
                                        <td>Nombre y apellido</td>
                                        <td>Numero de documento</td>
                                        <td colspan="1">Accion</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                     @foreach ($curso['docentes_curso'] as $docente_curso)
                                      <tr>
                                          <td>{{$docente_curso->legajo_personal}}</td>
                                          <td>{{$docente_curso->nombre_persona}} {{$alumno_curso->apellido_persona}}</td>
                                          <td>{{$docente_curso->dni_persona}}</td>
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
                  <!--BLOQUE MOSTRAR PRECEPTORES DEL CURSO-->
                     <div id="accordion5">
                        <div class="card">
                          <div class="card-header" id="heading{{$curso->id}}{{$curso->nombre_curso}}">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$curso->id}}{{$curso->nombre_curso}}" aria-expanded="false" aria-controls="collapse">
                               Preceptores
                              </button>
                              <a data-value="" onclick="" style="position: absolute; right: 30px; top: 10px; color: white; width: 150px;"class="btn btn-primary">Agregar preceptor</a>

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
                                          <td>{{$preceptor_curso->nombre_persona}} {{$alumno_curso->apellido_persona}}</td>
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

                @csrf
                <label for="materias">Materias :</label>
                <div id="listaMaterias"style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                  
                </div>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteAgregarMateria');">Cancelar</button>
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
                <label for="alumnos">Alumno :</label>
                <div id="listaAlumnos"style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                </div>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteAgregarAlumno');">Cancelar</button>
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


