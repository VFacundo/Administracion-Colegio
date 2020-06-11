/////////////////////////// CREAR PERSONAL /////////////////////////////////////////////////////////
function listarCrearPersonal() {
  var btn = event.target,
  id_personal,
  nombre_personal,
  texto,
  url = '/personal/listar_personal',
  formUpdate = document.getElementById('formAsignarPersonal');

  removeErrors('formCrearPersonal');
  
  document.getElementById('formCrearPersonal').innerHTML= '';
  try{
    document.getElementById('crearPersonal').remove();
    document.getElementById('cancelar').remove();
  }catch(error){}


  respuesta = ajaxRequest(url);
  respuesta.then(response => response.json())
  .then(function(response){

    console.log(response);
    legajo = '<label for="legajo_personal">Legajo :</label>' +
              '<input type="text" class="form-control" name="legajo_personal" placeholder="Legajo del personal. Numero de 6 digitos entre 100.000 y 200.000" required/></textarea>'

    S_personal = '<label for="personal">Personal :</label>' +
    '<select name="personal" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">';
            
      for(var i = 0;i < response['personas_personal'].length; i++){
        id_personal = response['personas_personal'][i]['id'];
        nombre_personal = response['personas_personal'][i]['nombre_persona'];
        apellido_personal = response['personas_personal'][i]['apellido_persona'];
        S_personal += '<option value= "'+ id_personal +'">'+nombre_personal +' '+apellido_personal +'</option>';
      }

    S_manejo = '<label for="manejo_de_grupo">Manejo de grupo :</label>' +
      '<select name="manejo_de_grupo" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">'+
        '<option value= "Malo">Malo</option>'+
        '<option value= "Regular">Regular</option>'+
        ' <option value= "Bueno">Bueno</option>'+
        '<option value= "Excelente">Excelente</option>'+
      '</select></p>';

    emergenteCrearPersonal = "'emergenteCrear'"
    boton_crearPersonal = '<button type="submit" class="btn btn-primary" id="crearPersonal" onclick="crearPersonal();">Crear Personal</button>';
    boton_cancelar = '<button type="reset" class="btn btn-primary" id="cancelar" onclick="activarEmergente('+ emergenteCrearPersonal +');">Cancelar</button>'

    document.getElementById('formCrearPersonal').insertAdjacentHTML('beforeend', legajo);
    document.getElementById('formCrearPersonal').insertAdjacentHTML('beforeend', S_personal);    
    document.getElementById('formCrearPersonal').insertAdjacentHTML('beforeend', S_manejo);
    document.getElementById('formCrearPersonal').insertAdjacentHTML('afterend', boton_cancelar);
    document.getElementById('formCrearPersonal').insertAdjacentHTML('afterend', boton_crearPersonal);
    
        
    });
}

function crearPersonal(){
  var btn = event.target,
  url = '/personal/store',
  dataRequest,
  personalBox = document.getElementById('formCrearPersonal').personal,
  manejoBox = document.getElementById('formCrearPersonal').manejo_de_grupo,
  legajoBox = document.getElementById('formCrearPersonal').legajo_personal,
  personal_a_crear,
  manejo_de_grupo,
  legajoPersonal,
  
  personal_a_crear = personalBox.value;
  manejo_de_grupo = manejoBox.value;
  legajoPersonal = legajoBox.value;

  removeErrors('formCrearPersonal');

  dataRequest = {
    legajo_personal:legajoPersonal,
    id_persona:personal_a_crear,
    manejo_de_grupo: manejo_de_grupo,
    fecha_alta: '2000-12-12',
  }

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      if(response[0] == 1) {
        emergente = "'emergenteCrear'";
        console.log(response);
        //console.log(response[1][0]['id']);
        label = '<label id="labelExiste" for="personal_existente">El legajo '+ legajoPersonal +' se encuentra dado de baja y puede estar asociado a otra persona que la seleccionada. Desea restaurarlo?</label>';
        boton_no = '<button id="Existe_no" type="reset" class="btn btn-primary" onclick="activarEmergente('+ emergente +');">NO</button>'        
        boton_si = '<button id="Existe_si" data-value="" id="agregarPersonal "type="submit" onclick="restaurarPersonal('+ response[1][0]['id'] +');"class="btn btn-primary">SI</button>'
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', label);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_si);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_no);
      }else {
        console.log(response);
        displayErrors(response,'formCrearPersonal');
      }         
    }else{
        console.log(response);
        emergente = "'emergenteUpdatePersonal'";
        document.getElementById("tablaPersonal").insertRow(-1).innerHTML =
        '<td>'+ response[1]['id'] +'</td>' +
        '<td>'+ response[2]['nombre_persona'] +'</td>' +
        '<td>'+ response[2]['apellido_persona'] +'</td>' +
        '<td>' + legajoPersonal +'</td>' +
        '<td>Ver datos personales</td>' +
        '<td> </td>' +
        '<td>'+ response[1]['fecha_alta'] +'</td>' +
        '<td>'+ response[1]['manejo_de_grupo'] +'</td>' +
        '<td><a id="btnUpdate" data-value="'+ response[1]['id'] +'" onclick="activarEmergente('+ emergente +');  updatePersonal(); " class="btn btn-primary">Editar</a></td>' +
        '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyPersonal('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
 
        mostrarModal('formCrearPersonal','Creado Correctamente!','Crear Personal','emergenteCrear');

        //activarEmergente('emergenteCrearPersonal');

    }
  
  });

}
///////////////////////////////// EDITAR PERSONAL //////////////////////////////////////////////////////////////////////////////////

////////////////// ENVIAR DATOS ACTUALIZADOS PERSONAL ////////////////////
function setUpdatePersonal(){
  var btn = event.target,
      btnUpdate = document.getElementsByClassName('toUpdate')[0],
      url = '/personal/actualizar',
      formUpdate = document.getElementById('formUpdatePersonal');

  removeErrors('formUpdatePersonal');
  console.log(form.legajo_personal.value);
  dataRequest = {
                 id:btn.dataset.value,
                 legajo_personal:form.legajo_personal.value,
                 manejo_de_grupo:form.manejo_de_grupo.value,
                };
  console.log('dataRequest', dataRequest);              
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      //btnUpdate.classList.remove("toUpdate");
      displayErrors(response,'formUpdatePersonal');
    }else{
      console.log(response);
      btnUpdate.classList.remove("toUpdate");
      emergente = "'emergenteUpdatePersonal'";
      //document.getElementsByClassName('modal')[0].remove();
      emergente = "'emergenteUpdateAlumno'";
      btnUpdate.parentNode.parentNode.innerHTML =
        '<td>'+ response[1]['id'] +'</td>' +
        '<td>'+ response[2]['nombre_persona'] +'</td>' +
        '<td>'+ response[2]['apellido_persona'] +'</td>' +
        '<td>'+ form.legajo_personal.value +'</td>' +
        '<td>Ver datos personales</td>' +
        '<td> </td>' +
        '<td>'+ response[1]['fecha_alta'] +'</td>' +
        '<td>'+ response[1]['manejo_de_grupo'] +'</td>' +
        '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updatePersonal(); " class="btn btn-primary">Editar</a></td>' +
        '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyPersonal('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
 
      mostrarModal('formUpdatePersonal','Modificado Correctamente!','Modificar Personal','emergenteUpdatePersonal');
    }
    });

}
////////////////////DISPLAY DATA DE PERSONAL //////
function updatePersonal(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdatePersonal'),
      id_update = btnUpdate.dataset.value,
      url = '/personal/editar', respuesta,dataRequest,text;

      removeErrors('formUpdatePersonal');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          console.log('response', response);
          formUpdate.legajo_personal.value = response['legajo_personal'];
          formUpdate.manejo_de_grupo.value = response['manejo_de_grupo'];
          btnUpdate.classList.add("toUpdate");
          document.querySelector('#formUpdatePersonal [type="submit"]').dataset.value = response['id'];
        });
        console.log("editar personal");
}

/////////////////////////////////////////// ELIMINAR PERSONAL /////////////////////////////////////////////////////////////////////////

/////////////////CONFIRMAR ELIMINAR PERSONAL ///////////////////
function confirmDestroyPersonal(id_personal){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Personal </h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarPersonal('+id_personal+')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyPersonal(id_personal);
  console.log(btnDestroy);
}

function modalBodyPersonal(id_personal){
var url = '/personal/editar', respuesta,dataRequest,bModal;

  dataRequest = {id:id_personal};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
    bModal.insertAdjacentHTML('beforeend','<b> Legajo: '+ response['legajo_personal'] +'</b><br>'+
                              '<b> Nombre: '+response['nombre_personal']+'</b><br>'+
                              '<b> Apellido: '+response['apellido_personal']+'</b><br>'
      )
      return response;
  });

}

///////////////// ELIMINAR PERSONAL ////////////////////////
function eliminarPersonal(id_personal){
  var respuesta,
      url = '/personal/destroy',
      dataRequest,
      btn = event.target,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id_personal:id_personal,
                }; 
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      btnDestroy.classList.remove("toDestroy");
      document.getElementsByClassName('modal')[0].remove();
      //mostrarModal('tablaPersonas','No fue posible eliminar la Persona Seleccionada!','Eliminar Persona','null');
    }else{
      btnDestroy.parentNode.parentNode.remove();
      document.getElementsByClassName('modal')[0].remove();
    }
  });
}

/////////////////////////////////// RESTAURAR PERSONAL //////////////////////////////////////////////
function restaurarPersonal(id_personal){
  var btn = event.target,
  dataRequest,
  url = '/personal/restaurarPersonal';

  dataRequest = {id_personal: id_personal};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
    } else {
      emergente = "'emergenteUpdatePersonal'";
      document.getElementById('labelExiste').remove();
      document.getElementById('Existe_no').remove();
      document.getElementById('Existe_si').remove();
      document.getElementById("tablaPersonal").insertRow(-1).innerHTML =
      '<td>'+ response[1]['id'] +'</td>' +
      '<td>'+ response[2]['nombre_persona'] +'</td>' +
      '<td>'+ response[2]['apellido_persona'] +'</td>' +
      '<td>' + response[1]['legajo_personal'] +'</td>' +
      '<td>Ver datos personales</td>' +
      '<td> </td>' +
      '<td>'+ response[1]['fecha_alta'] +'</td>' +
      '<td>'+ response[1]['manejo_de_grupo'] +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1]['id'] +'" onclick="activarEmergente('+ emergente +');  updatePersonal(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyPersonal('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
 
      mostrarModal('formCrearPersonal','El personal se dio nuevamente de alta!','Crear Personal','emergenteCrear');
        
    }
 
  });    
}