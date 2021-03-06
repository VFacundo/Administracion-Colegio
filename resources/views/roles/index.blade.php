@extends('layout')

@section('content')

<!--ROLES -->
<div class="row table-before-row">
  <!-- Barra de Busqueda -->
  @include('partials.buscador',['section'=>'Roles','tableId'=>'tablaRoles'])
  <!-- Barra de Busqueda FIN-->
  <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergenteCrear');">Agregar Rol</a></div>
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
  <table class="table cell-border stripe hover" id="tablaRoles">
    <thead>
        <tr>
          <th>Nombre Rol</th>
          <th>Descripcion Rol</th>
          <th>Estado de Rol</th>
          <th>Permisos</th>
          <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $rol)
        <tr>
            <td>{{$rol->nombre_rol}}</td>
            <td>{{$rol->descripcion_rol}}</td>
            <td>{{$rol->estado_rol}}</td>
            <td>
            @foreach($rol['permisos'] as $perm)
              {{$perm->nombre_permiso}} | {{date("d/m/Y", strtotime($perm->fecha_asignacion_permiso))}} <br>
            @endforeach
            </td>
            <td>
              <a id="btnUpdate" data-value="{{ ($rol->nombre_rol)}}" onclick="activarEmergente('emergenteUpdate'); updateRol()" class="btn btn-primary">Editar</a>
              <a data-value="{{ ($rol->nombre_rol)}}" onclick="confirmDestroyModal('{{ ($rol->nombre_rol)}}','eliminarRegistro','roles')" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
          <th>Nombre Rol</th>
          <th>Descripcion Rol</th>
          <th>Estado de Rol</th>
          <th>Permisos</th>
          <th>Accion</th>
        </tr>
    </tfoot>
  </table>
<div>
<!--PERMISOS -->

<div class="row table-before-row separadorPermisos">
    <!-- Barra de Busqueda -->
    @include('partials.buscador',['section'=>'Permisos','tableId'=>'tablaPermisos'])
    <!-- Barra de Busqueda FIN-->
    <div class="col-sm-2"><a class="btn btn-primary" id="btnEmergente" onclick="activarEmergente('emergentePermisos');">Agregar Permiso</a></div>
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
    <table class="table cell-border stripe hover" id="tablaPermisos">
      <thead>
          <tr>
            <th>Nombre Permiso</th>
            <th>Funcionalidad Permiso</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Accion</th>
          </tr>
      </thead>
      <tbody>
          @foreach($permisos as $permiso)
          <tr>
              <td>{{$permiso->nombre_permiso}}</td>
              <td>{{$permiso->funcionalidad_permiso}}</td>
              <td>{{$permiso->descripcion_permiso}}</td>
              <td>{{$permiso->estado_permiso}}</td>
              <td>
                <a id="btnUpdate" data-value="{{ ($permiso->id)}}" onclick="activarEmergente('emergentePermisoUpdate'); updatePermiso();" class="btn btn-primary">Editar</a>
                <a data-value="{{ ($permiso->id)}}" onclick="confirmDestroyModal({{ ($permiso->id)}},'eliminarRegistro','permisos')" class="btn btn-danger">Eliminar</a>
              </td>
          </tr>
          @endforeach
      </tbody>
      <tfoot>
          <tr>
            <th>Nombre Permiso</th>
            <th>Funcionalidad Permiso</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Accion</th>
          </tr>
      </tfoot>
    </table>
    <div>
<div>
@endsection

<!--BLOQUE CREAR NUEVO ROL -->
<div class="padreEmergente">
  <div class="emergente" id="emergenteCrear">
    <div class="card-header">
      Crear Rol Nuevo
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
        <form method="post" onSubmit="return false;" id="formAltaRol">

                @csrf
                <label for="nombre_rol">Nombre Rol :</label>
                <input type="text" class="form-control" name="nombre_rol" placeholder="Nombre Rol" required/></textarea>

                <label for="descripcion_rol">Descripcion :</label>
                <input type="text" class="form-control" name="descripcion_rol" placeholder="Descripcion" required/></textarea>

                <label for="estado_rol">Estado :</label>
                <select name="estados">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select></br>

                <label for="permisos_box">Permisos :</label>
                <div style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                  @foreach($permisos as $permiso)
                    <input type="checkbox" name="permisos_box" value="{{ ($permiso->id)}}">
                    <label for="permisos_box">{{ ($permiso->nombre_permiso)}}</label><br>
                  @endforeach
                </div>
            <button type="submit" class="btn btn-primary" onclick="crearRol();">Crear Rol</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteCrear');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVO ROL -->

<!--BLOQUE CREAR NUEVO PERMISO -->
<div class="padreEmergente">
  <div class="emergente" id="emergentePermisos">
    <div class="card-header">
      Crear Permiso Nuevo
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
        <form method="post" id="formAltaPermiso" onSubmit="return false;">
                @csrf
                <label for="nombre_permiso">Nombre Permiso :</label>
                <input type="text" class="form-control" name="nombre_permiso" placeholder="Nombre Permiso" required/></textarea>

                <label for="funcionalidad_permiso">Funcionalidad Permiso :</label>
                <input type="text" class="form-control" name="funcionalidad_permiso" placeholder="Funcionalidad Permiso" required/></textarea>

                <label for="descripcion_permiso">Descripcion Permiso :</label>
                <input type="text" class="form-control" name="descripcion_permiso" placeholder="Descripcion Permiso" required/></textarea>

                <label for="estado_permiso">Estado :</label>
                <select name="estados">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select></br>

            <button type="submit" class="btn btn-primary" onclick="crearPermiso();">Crear Permiso</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergentePermisos');">Cancelar</button>
        </form>
    </div>
  </div>
</div>

<!--FIN BLOQUE CREAR NUEVO PERMISO -->

<!--BLOQUE EDITAR ROL -->
<div class="padreEmergente">
  <div class="emergente" id='emergenteUpdate'>
    <div class="card-header">
      Editar Rol
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
                <label for="nombre_rol">Nombre Rol :</label>
                <input type="text" class="form-control" name="nombre_rol" placeholder="Nombre Rol" required/></textarea>

                <label for="descripcion_rol">Descripcion :</label>
                <input type="text" class="form-control" name="descripcion_rol" placeholder="Descripcion" required/></textarea>

                <label for="estado_rol">Estado :</label>
                <select name="estados">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select></br>

                <label for="permisos_box">Permisos :</label>
                <div style="min-height:80px;padding:15px;border:1px solid #ccc;overflow:auto;">
                  @foreach($permisos as $permiso)
                    <input type="checkbox" name="permisos_box" value="{{ ($permiso->id)}}">
                    <label for="permisos_box">{{ ($permiso->nombre_permiso)}}</label><br>
                  @endforeach
                </div>

            <button type="submit" class="btn btn-primary" onclick="setUpdateRol();">Modificar Rol</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergenteUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR PERSONA -->

<!--BLOQUE EDITAR PERMISO -->
<div class="padreEmergente">
  <div class="emergente" id='emergentePermisoUpdate'>
    <div class="card-header">
      Editar Permiso
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
        <form id="formUpdatePermisos" onSubmit="return false;">

                @csrf
                <label for="nombre_permiso">Nombre Permiso :</label>
                <input type="text" class="form-control" name="nombre_permiso" placeholder="Nombre Permiso" required/></textarea>

                <label for="funcionalidad_permiso">Funcionalidad Permiso :</label>
                <input type="text" class="form-control" name="funcionalidad_permiso" placeholder="Funcionalidad Permiso" required/></textarea>

                <label for="descripcion_permiso">Descripcion Permiso :</label>
                <input type="text" class="form-control" name="descripcion_permiso" placeholder="Descripcion Permiso" required/></textarea>

                <label for="estado_permiso">Estado :</label>
                <select name="estados">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select></br>

            <button type="submit" class="btn btn-primary" onclick="setUpdatePermiso();">Modificar Permiso</button>
            <button type="reset" class="btn btn-primary" onclick="activarEmergente('emergentePermisoUpdate');">Cancelar</button>
        </form>
    </div>
  </div>
</div>
<!--FIN BLOQUE EDITAR PERMISO -->
