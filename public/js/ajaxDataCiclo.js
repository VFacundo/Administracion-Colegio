////////////////// ENVIAR DATOS ACTUALIZADOS CICLO ////////////////////
function setUpdateCiclo(){
  var btn = event.target,
      btnUpdate = document.getElementsByClassName('toUpdate')[0],
      url = '/ciclo/actualizar',
      formUpdate = document.getElementById('formUpdate');

  removeErrors('formUpdate');
  dataRequest = {id:btn.dataset.value,
                anio:formUpdate.anio.value,
                nombre:'Ciclo Lectivo ' + form.anio.value,
                };
  console.log(dataRequest);              
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      //btnUpdate.classList.remove("toUpdate");
      displayErrors(response,'formUpdate');
    }else{
      console.log(btnUpdate);
      btnUpdate.classList.remove("toUpdate");
      emergente = "'emergenteUpdate'";
      //document.getElementsByClassName('modal')[0].remove();
      btnUpdate.parentNode.parentNode.innerHTML =
      '<td>'+ response[2] +'</td>' +
      '<td>'+ form.anio.value +'</td>' +
      '<td>Ciclo Lectivo ' + form.anio.value +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[2] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1] +'" href="curso/'+ response[1] +'" class= "btn btn-primary">Ver Cursos</a></td>' +
      '<td><a data-value="'+ response[1] +'" onclick="" class="btn btn-danger">Eliminar</a></td>';
      //document.getElementsByClassName('modal')[0].remove();
      mostrarModal('formUpdate','Modificado Correctamente!','Modificar Ciclo Lectivo','emergenteUpdate');
    }
    });

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
          btnUpdate.classList.add("toUpdate");
          console.log(btnUpdate);
          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];

        });
        console.log("editar ciclo");
}


///////////////// CREAR CICLO LECTIVO ///////////////////////////////////

function crearCiclo(){
  var btn = event.target,
      form = btn.parentNode,
      dataRequest,
      url = '/ciclo/store',
      respuesta,
      nuevaFila;
  
  removeErrors('formAltaCiclo');

  //console.log(form.estados.value);
  dataRequest = {
    anio:form.anio.value,
    nombre:'Ciclo Lectivo ' + form.anio.value,
  }
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      if(response[0] == 1) {
        emergente = "'emergenteCrear'";
        console.log(response);
        console.log(response[1][0]['id']);
        label = '<label id="labelExiste" for="ciclo_existente">El ciclo lectivo '+ form.anio.value  +' se encuentra dado de baja. Desea restaurarlo?</label>';
        boton_no = '<button id="Existe_no" type="reset" class="btn btn-primary" onclick="activarEmergente('+ emergente +');">NO</button>'        
        boton_si = '<button id="Existe_si" data-value="" id="agregarAlumno"type="submit" onclick="restaurarCiclo('+ response[1][0]['id'] +');"class="btn btn-primary">SI</button>'
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', label);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_si);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_no);
      }else {
        console.log(response);
        displayErrors(response,'formAltaCiclo'); 
      }
    }else{
      console.log(response);
      emergente = "'emergenteUpdate'";
      document.getElementById("tablaCiclos").insertRow(-1).innerHTML =
      '<td>'+ response[1] +'</td>' +
      '<td>'+ form.anio.value +'</td>' +
      '<td>Ciclo Lectivo ' + form.anio.value +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1] +'" href="curso/'+ response[1] +'" class= "btn btn-primary">Ver Cursos</a></td>' +
      '<td><a data-value="'+ response[1] +'" onclick="confirmDestroyCiclo('+ response[1] +')" class="btn btn-danger">Eliminar</a></td>';
      mostrarModal('formAltaCiclo','El ciclo lectivo se creo exitosamente!','Crear Ciclo Lectivo','emergenteCrear');
    }
  });
}

/////////////////CONFIRMAR ELIMINAR UN CICLO LECTIVO ///////////////////
function confirmDestroyCiclo(id_ciclo){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Ciclo Lectivo</h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarCicloLectivo('+ id_ciclo +')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyCiclo(id_ciclo);
  console.log(btnDestroy);
}


function modalBodyCiclo(id_ciclo){
var url = '/ciclo/editar', respuesta,dataRequest,bModal;

  dataRequest = {id:id_ciclo};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log('respuesta', response);
    bModal.insertAdjacentHTML('beforeend','<b> Año: '+response['anio']+'</b><br>'+
                              '<b> Nombre: '+response['nombre']+'</b><br>'
      )
      return response;
  });

}

///////////////// ELIMINAR CICLO LECTIVO////////////////////////
function eliminarCicloLectivo(id_ciclo){
  var respuesta,
      url = '/ciclo/destroy',
      dataRequest,
      btn = event.target,
      row,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id_ciclo:id_ciclo,
                }; 
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      btnDestroy.parentNode.parentNode.remove();
      btnDestroy.classList.remove("toDestroy");
      document.getElementsByClassName('modal')[0].remove();
      mostrarModal('tablaCiclos','El ciclo lectivo seleccionado tiene cursos asociados, por este motivo no fue eliminado, solo fue dado de baja','Eliminar Ciclo Lectivo','null');
    }else{
      btnDestroy.parentNode.parentNode.remove();
      document.getElementsByClassName('modal')[0].remove();
      mostrarModal('tablaCiclos','El ciclo fue eliminado exitosamente!','Eliminar Ciclo Lectivo','null');

    }
  });
}

///////////////// RESTAURAR CICLO LECTIVO////////////////////////
function restaurarCiclo(id_ciclo){
  var btn = event.target,
  ciclo_a_restaurar,
  dataRequest,
  url = '/ciclo/restaurarCiclo';

  dataRequest = {id_ciclo: id_ciclo};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
    } else {
      emergente = "'emergenteUpdate'";
      document.getElementById('labelExiste').remove();
      document.getElementById('Existe_no').remove();
      document.getElementById('Existe_si').remove();
      document.getElementById("tablaCiclos").insertRow(-1).innerHTML =
      '<td>'+ response[1]['id'] +'</td>' +
      '<td>'+ response[1]['anio']+'</td>' +
      '<td>' + response[1]['nombre'] +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1]['id'] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1]['id'] +'" href="curso/'+ response[1]['id'] +'" class= "btn btn-primary">Ver Cursos</a></td>' +
      '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyCiclo('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
      mostrarModal('formAltaCiclo','El ciclo lectivo se dio nuevamente de alta!','Crear Ciclo Lectivo','emergenteCrear');
        
    }
 
  });    
}
