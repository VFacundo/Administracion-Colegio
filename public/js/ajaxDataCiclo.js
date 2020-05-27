////////////////// ENVIAR DATOS ACTUALIZADOS CICLO ////////////////////
function setUpdateCiclo(){
  var btn = event.target,
      url = '/ciclo/actualizar',
      formUpdate = document.getElementById('formUpdate');

  removeErrors('formUpdate');
  dataRequest = {id:btn.dataset.value,
                anio:formUpdate.anio.value,
                nombre:formUpdate.nombre.value,
                };
  console.log(dataRequest);              
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      displayErrors(response,'formUpdate');
    }else{
      mostrarModal('formUpdate','Modificado Correctamente!','Modificar Ciclo Lectivo','emergenteUpdate');
   
    }
    });

}

function ocultarModal(formName,emergente){
  document.getElementsByClassName('modal')[0].remove();
  //console.log(emergente.id);
  //emergente.style.display="none";
  //document.getElementById(emergente).style.display="none";
  //activarEmergente('emergenteUpdate');-->antes
  if(emergente != 'null'){
        activarEmergente(emergente.id);
  }
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

////////////////////DISPLAY DATA DE CICLO //////
function updateCiclo(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/ciclo/editar', respuesta,dataRequest,text;

      removeErrors('formUpdate');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          console.log(response);
          formUpdate.anio.value = response['anio'];
          formUpdate.nombre.value = response['nombre'];
          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];
        });
        console.log("editar ciclo");
}

////////////////// ENVIAR DATOS ACTUALIZADOS USUARIOS ////////////////////

///////////////// CREAR CICLO LECTIVO ///////////////////////////////////

function crearCiclo(){
  var btn = event.target,
      form = btn.parentNode,
      dataRequest,
      url = '/ciclo/store',
      respuesta,
      nuevaFila;

 
  //console.log(form.estados.value);
  dataRequest = {
    anio:form.anio.value,
    nombre:form.nombre.value,
  }
  console.log(dataRequest);

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      displayErrors(response,'formAltaCiclo');
       //btnDestroy.classList.remove("toDestroy");
    }else{

 

      activarEmergente('emergenteCrear');
    }
  });
  console.log(dataRequest);
}