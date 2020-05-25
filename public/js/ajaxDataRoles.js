function crearPermiso(){
  var btn = event.target,
      form = btn.parentNode,
      dataRequest,
      url = '/permisos/store',
      respuesta,
      nuevaFila;

  //console.log(form.estados.value);
  dataRequest = {
    nombre_permiso:form.nombre_permiso.value,
    funcionalidad_permiso:form.funcionalidad_permiso.value,
    estado_permiso:form.estados.value,
    descripcion_permiso:form.descripcion_permiso.value,
  }

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      displayErrors(response,'formAltaPermiso');
       //btnDestroy.classList.remove("toDestroy");
    }else{

    document.getElementById('tablaPermisos').children[1].insertAdjacentHTML('beforeend','<tr>'+
          '<td>'+form.nombre_permiso.value+'</td>'+
          '<td>'+form.funcionalidad_permiso.value+'</td>'+
          '<td>'+form.descripcion_permiso.value+'</td>'+
          '<td>'+form.estados.value+'</td>'+
          '<td><a id="btnUpdate" data-value="'+response[1]+'" onclick="activarEmergente('+'emergentePermisoUpdate'+'); updatePermiso();" class="btn btn-primary">Edit</a></td>'+
          '<td><a data-value="'+response[1]+'" onclick="confirmDestroy('+response[1]+')" class="btn btn-danger">Delete</a></td>'+
      '</tr>');

      activarEmergente('emergentePermisos');
    }
  });
  console.log(dataRequest);
}

///Display infor. de Permisos
function updatePermiso(){
var btnUpdate = event.target,
    formUpdate = document.getElementById('formUpdatePermisos'),
    id_update = btnUpdate.dataset.value,
    url = '/permisos/update',respuesta,dataRequest;

    removeErrors('formUpdatePermisos');
    dataRequest = {id:id_update}; //Datos a Enviar
    respuesta = ajaxRequest(url,dataRequest)
    respuesta.then(response => response.json())
      .then(function(response){
        formUpdate.nombre_permiso.value = response['nombre_permiso'];
        formUpdate.funcionalidad_permiso.value = response['funcionalidad_permiso'];
        formUpdate.descripcion_permiso.value = response['descripcion_permiso'];
        formUpdate.estados.value = response['estado_permiso'];
        document.querySelector('#formUpdatePermisos [type="submit"]').dataset.value = response['id'];
        console.log(response);
      });
      console.log("editar permisos");
}

function setUpdatePermiso(){
  var btn = event.target,
      url = '/permisos/setupdate',
      formUpdate = document.getElementById('formUpdatePermisos'),respuesta;

  removeErrors('formUpdatePermisos');
  dataRequest = {
    id:btn.dataset.value,
    nombre_permiso:formUpdate.nombre_permiso.value,
    funcionalidad_permiso:formUpdate.funcionalidad_permiso.value,
    descripcion_permiso:formUpdate.descripcion_permiso.value,
    estado_permiso:formUpdate.estados.value,
  };

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      displayErrors(response,'formUpdatePermisos');
    }else{
      mostrarModal('formUpdatePermisos','Modificado Correctamente!','Modificar Permiso','emergentePermisoUpdate');
    }
    });
}

/////////////////CONFIRMAR ELIMINAR GENERICO ///////////////////
function confirmDestroyModal(id,metodo,controlador){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar</h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="'+metodo+'('+"'"+id+"'"+','+"'"+controlador+"'"+');">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyCreate(id,controlador);
  console.log(btnDestroy);
}

function modalBodyCreate(id,controlador){
  var url = '/'+controlador+'/update',respuesta,dataRequest,bModal,modalCode ='',nombreCampo;

  dataRequest = {id:id};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    Object.keys(response).forEach(function(elemento,indice,array){
      if(elemento != 'id'){
        nombreCampo = elemento.replace('_',' ');
        modalCode += '<b> '+nombreCampo+': '+response[elemento]+'</b><br>';
      }
    });
    bModal.insertAdjacentHTML('beforeend', modalCode);
      return response;
  });
}

///// ELIMINAR GENERICO /////////////////
// id -> id del elemento a eliminar
// Controlador -> nombre del Controlador
function eliminarRegistro(id,controlador){
var respuesta,
    url = '/'+controlador+'/destroy',
    dataRequest,btn = event.target,
    btnDestroy = document.getElementsByClassName("toDestroy")[0];

  dataRequest = {id:id};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      btnDestroy.classList.remove("toDestroy");
      document.getElementsByClassName('modal')[0].remove();
      mostrarModal('formUpdatePermisos','No se puede Eliminar el Permiso Seleccionado!','Eliminar Permiso','null');
    }else{
      btnDestroy.parentNode.parentNode.remove();
      document.getElementsByClassName('modal')[0].remove();
    }
  });
}

////////////ROLES

function crearRol(){
  var btn = event.target,
      form = btn.parentNode,
      dataRequest,
      url = '/roles/store',
      respuesta,
      nuevaFila,
      permisosRol=[],
      permisosBox =[],
      nuevoReg,regPermisos;

  //Revisar que cuando, se tiene un solo permiso rompe
  permisosBox = form.permisos_box;
  console.log(form.permisos_box);
  console.log(permisosBox);
  console.log(permisosBox.length);
  for (var i = 0; i < permisosBox.length; i++) {
    if(permisosBox[i].checked){
      permisosRol[permisosRol.length] = permisosBox[i].value;
      console.log(permisosRol);
    }
  }
  dataRequest = {
    nombre_rol:form.nombre_rol.value,
    descripcion_rol:form.descripcion_rol.value,
    estado_rol:form.estados.value,
    permisos:permisosRol,
  }
  console.log(dataRequest);
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      displayErrors(response,'formAltaPermiso');
       //btnDestroy.classList.remove("toDestroy");
    }else{
      console.log("ok");
      for (var i = 0; i < response[1].length; i++) {
        regPermisos = response[1][i]['nombre_permiso']+' | '+response[1][i]['fecha_asignacion_permiso']+'<br>';
      }
      nuevoReg ='<tr>'+
                  '<td>'+dataRequest['nombre_rol']+'</td>'+
                  '<td>'+dataRequest['descripcion_rol']+'</td>'+
                  '<td>'+dataRequest['estado_rol']+'</td>'+
                  '<td>'+regPermisos+'</td>'+
                '</tr>';
                // regPermisos;
      document.getElementById('tablaRoles').children[1].insertAdjacentHTML('beforeend',nuevoReg);
        console.log(nuevoReg);
        activarEmergente('emergenteCrear');
    }
  });
}

///Display infor. de Permisos
function updateRol(){
var btnUpdate = event.target,
    formUpdate = document.getElementById('formUpdate'),
    id_update = btnUpdate.dataset.value,
    url = '/roles/update',respuesta,dataRequest,checkBox;

    removeErrors('formUpdatePermisos');
    dataRequest = {id:id_update}; //Datos a Enviar
    respuesta = ajaxRequest(url,dataRequest)
    respuesta.then(response => response.json())
      .then(function(response){
        console.log(response);
        formUpdate.nombre_rol.value = response['nombre_rol'];
        formUpdate.descripcion_rol.value = response['descripcion_rol'];
        formUpdate.estados.value = response['estado_rol'];
        document.querySelector('#formUpdatePermisos [type="submit"]').dataset.value = response['nombre_rol'];
        checkBox = document.getElementsByName("permisos_box");
        for (var i = 0; i < response['permisos'].length; i++) {
          console.log(response['permisos']);
          console.log(response['permisos'][0]);
          for (var j = 0; j < checkBox.length; j++) {
            if(checkBox[j].value == response['permisos'][i]['id_permiso']){
              checkBox[j].checked = true;
            }
          }
          response['permisos'][i]
        }
        console.log(response);
      });
      console.log("editar permisos");
}
