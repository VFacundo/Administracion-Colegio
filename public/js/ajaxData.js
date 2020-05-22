function updateUser_backup(){
  var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      btnUpdate = document.getElementById('btnUpdate'),
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/usuarios/editar', respuesta;

      fetch(url, {
     headers: {
       "Content-Type": "application/json",
       "Accept": "application/json, text-plain, */*",
       "X-Requested-With": "XMLHttpRequest",
       "X-CSRF-TOKEN": csrf_token
      },
     method: 'post',
     credentials: "same-origin",
     body: JSON.stringify({
       id: id_update
     })
    })
      .then(function(data) {
        return data.text();
      })
      .then(function(text) {
        respuesta = JSON.parse(text);
        formUpdate.name.value = respuesta['name'];
        formUpdate.email.value = respuesta['email'];
        formUpdate.id_persona.value = respuesta['id_persona'];
        console.log('Request successful', respuesta);
      })
    .catch(function(error) {
        console.log(error);
      });

  console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
}

/////////////////CONFIRMAR ELIMINAR PERSONA ///////////////////
function confirmDestroy(id_persona){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Persona</h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarPersona('+id_persona+')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBody(id_persona);
  console.log(btnDestroy);
}

function modalBody(id_persona){
var url = '/personas/editar', respuesta,dataRequest,bModal;

  dataRequest = {id:id_persona};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
    bModal.insertAdjacentHTML('beforeend','<b> Legajo: '+response['legajo']+'</b><br>'+
                        '<b> Nombre: '+response['nombre_persona']+'</b><br>'+
                        '<b> Apellido: '+response['apellido_persona']+'</b><br>'+
                        '<b> Tipo Documento: '+response['tipo_documento']+'</b><br>'+                
                        '<b> DNI: '+response['dni_persona']+'</b><br>'+
                        '<b> CUIL: '+response['cuil_persona']+'</b><br>'+                        
                        '<b> Domicilio: '+response['domicilio']+'</b><br>'+
                        '<b> Fecha Nacimiento: '+response['fecha_nacimiento']+'</b><br>'+
                        '<b> Telefono: '+response['numero_telefono']+'</b><br>');
      return response;
  });

}

/////////////////// BORRAR MODAL DESTROY/////////////////////
function deleteModalD(){
  var btn = event.target,
      modal = document.getElementsByClassName('modal')[0],
      btnDestroy = document.getElementsByClassName("toDestroy");

if(btnDestroy.length>0){
  btnDestroy[0].classList.remove("toDestroy");
}

modal.remove();

}

///////////////// ELIMINAR PERSONA ////////////////////////
function eliminarPersona(id_persona){
  var respuesta,
      url = '/personas/destroy',
      dataRequest,
      btn = event.target,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id:id_persona};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      btnDestroy.classList.remove("toDestroy");
    }else{
      btnDestroy.parentNode.parentNode.remove();
    }
  });
}

///////////////// OBTENER DATOS DE PERSONA ////////////////////
function getPersona(id_persona){
var url = '/personas/editar', respuesta,dataRequest;

  dataRequest = {id:id_persona};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
      return response;
  });

}

////////////////// ENVIAR DATOS ACTUALIZADOS PERSONA ////////////////////
function setUpdatePersona(){
  var btn = event.target,
      url = '/personas/actualizar',
      formUpdate = document.getElementById('formUpdate');

  removeErrors('formUpdate');
  dataRequest = {id:btn.dataset.value,
                legajo:formUpdate.legajo.value,
                nombre_persona:formUpdate.nombre_persona.value,
                apellido_persona:formUpdate.apellido_persona.value,
                tipo_documento:formUpdate.tipo_documento.value,
                dni_persona:formUpdate.dni_persona.value,
                cuil_persona:formUpdate.cuil_persona.value,
                domicilio:formUpdate.domicilio.value,
                fecha_nacimiento:formUpdate.fecha_nacimiento.value,
                numero_telefono:formUpdate.numero_telefono.value,
                estado_persona:formUpdate.estado_persona.value
                  };
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      displayErrors(response,'formUpdate');
    }else{
      mostrarModal('formUpdate','Modificado Correctamente!','Modificar Persona','emergenteUpdate');
    }
    });
}

function ocultarModal(formName,emergente){
  document.getElementsByClassName('modal')[0].remove();
  console.log(emergente);
  //emergente.style.display="none";
  //document.getElementById(emergente).style.display="none";
  activarEmergente('emergenteUpdate');
}

function mostrarModal(formName,mensaje,titulo,emergente){
  var nDiv = document.createElement("div"),
      modal = document.getElementsByClassName('modal');

document.getElementById(formName).parentNode.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog">'+
                      '<div class="modal-dialog" role="document">'+
                        '<div class="modal-content">'+
                          '<div class="modal-header">'+
                              '<h5 class="modal-title">' + titulo + '</h5>'+
                              '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                              '</button>'+
                          '</div>'+
                          '<div class="modal-body">'+
                            '<p>' + mensaje + '</p>'+
                          '</div>'+
                          '<div class="modal-footer">'+
                            '<button type="button" class="btn btn-primary" onclick="ocultarModal('+ formName + ',' + emergente +');">Aceptar</button>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>');
modal[0].style.display = "block";
}

////////////////////DISPLAY DATA DE PERSONA //////
function updatePersona(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/personas/editar', respuesta,dataRequest,text;

      removeErrors('formUpdate');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          formUpdate.legajo.value = response['legajo'];
          formUpdate.nombre_persona.value = response['nombre_persona'];
          formUpdate.apellido_persona.value = response['apellido_persona'];
          formUpdate.tipo_documento.value = response['tipo_documento'];
          formUpdate.dni_persona.value = response['dni_persona'];
          formUpdate.cuil_persona.value = response['cuil_persona'];
          formUpdate.domicilio.value = response['domicilio'];
          formUpdate.fecha_nacimiento.value = response['fecha_nacimiento'];
          formUpdate.numero_telefono.value = response['numero_telefono'];
          formUpdate.estado_persona.value = response['estado_persona'];
          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];
        });
        console.log("editar persona");
}

////////////////// ENVIAR DATOS ACTUALIZADOS USUARIOS ////////////////////
function setUpdateUser(){
  var btn = event.target,
      url = '/usuarios/actualizar',
      formUpdate = document.getElementById('formUpdate');

  removeErrors('formUpdate');
  dataRequest = {id:btn.dataset.value,
                  name:formUpdate.name.value,
                  email:formUpdate.email.value,
                  id_persona:formUpdate.id_persona.value};
  console.log(dataRequest);
  respuesta = ajaxRequest(url,dataRequest);
  console.log(respuesta);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != '500'){
       console.log(response[0]);
      displayErrors(response,'formUpdate');
     }
    });
}

/////////////////////////// BORRAR ERRORES /////////////
function removeErrors(formName){
  try{
    form = document.getElementById(formName);
    divPadre = form.parentNode;
    divHijos = divPadre.querySelectorAll(".alert.alert-danger");

    for (var i = 0; i < divHijos.length; i++) {
      divPadre.removeChild(divHijos[i]);
    }
  }catch(error){
    console.log(error);
  }

}

//////////////////////////// MOSTRAR ERRORES //////////////////////
function displayErrors(arrayErrores,formName){
var div, ul,li;

  div = document.createElement("div");
  ul = document.createElement("ul");
  div.classList.add("alert");
  div.classList.add("alert-danger");
  div.appendChild(ul);

for(var i = 0; i < arrayErrores.length ; i++){
  li = document.createElement("li");
  li.innerHTML = arrayErrores[i];
  ul.appendChild(li);
}

document.getElementById(formName).parentNode.appendChild(div);
}

//////////////////////////// ACTUALIZAR USUARIO /////////////////////
function updateUser(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/usuarios/editar', respuesta,dataRequest,text;

      removeErrors('formUpdate');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          formUpdate.name.value = response['name'];
          formUpdate.email.value = response['email'];
          formUpdate.id_persona.value = response['id_persona'];
          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];
        });
}

///////////////////////// AJAX REQUEST ////////////////////////////
function ajaxRequest(url,dataRequest){
  var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    return  fetch(url, {
     headers: {
       "Content-Type": "application/json",
       "Accept": "application/json, text-plain, */*",
       "X-Requested-With": "XMLHttpRequest",
       "X-CSRF-TOKEN": csrf_token
      },
     method: 'post',
     credentials: "same-origin",
     body: JSON.stringify(
       dataRequest
     )
   })
 }
