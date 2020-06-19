function listarAlumnos(id_curso) {
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto = '',
  url = '/alumno/listar',
  formUpdate = document.getElementById('formAsignarAlumno');

  removeErrors('formAsignarAlumno');
  dataRequest = {curso_id:btn.dataset.value,
                };
  console.log(dataRequest); 
  try{
    document.getElementById('boton_crear').remove();
    document.getElementById('boton_cancelar').remove();

  }catch(error){}

  tabla = '<table id="tablaAsignarAlumnos" class="data-table table table-striped">'+
                    '<thead>'+
                      '<tr>'+
                        '<th>Alumno</th>'+
                       ' <th>Agregar</th>'+
                      '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                    '</tbody>'+
                    '<tfoot>'+
                      '<tr>'+
                        '<th>Alumno</th>'+
                        '<th>Agregar</th>'+
                      '</tr>'+
                    '</tfoot>'+
                  '</table>'+
                  '</div>';

  document.getElementById('formAsignarAlumno').insertAdjacentHTML('beforeend',tabla);


  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
    console.log(response);

    
    for(var i = 0;i < response['alumnos'].length; i++){
        id_alumno = response['alumnos'][i]['id'];
        nombre_alumno = response['alumnos'][i]['nombre_persona'];
        apellido_alumno = response['alumnos'][i]['apellido_persona'];          
        texto += '<tr>'+
                '<td>'+ nombre_alumno +' '+ apellido_alumno +'</td>' + 
                '<td> <input type="checkbox" name="alumnos" value="'+ id_alumno +'"> </td>'+
                '</tr>';        
    }

        document.querySelector('#tablaAsignarAlumnos>tbody').insertAdjacentHTML('beforeend', texto);
        
        emergenteAgregarAlumno = "'emergenteAgregarAlumno'";  
        boton_crear = '<button data-value="'+ id_curso +'" id="boton_crear"type="submit" onclick="asignarAlumnoCurso(); limpiarTablaAlumnos();"class="btn btn-primary">Agregar a curso</button>'
        boton_cancelar ='<button id="boton_cancelar" type="reset" class="btn btn-primary" onclick="activarEmergente('+ emergenteAgregarAlumno +'); limpiarTablaAlumnos();  ">Cancelar</button>'
        document.getElementById('tablaAsignarAlumnos').insertAdjacentHTML('afterend', boton_cancelar);
        document.getElementById('tablaAsignarAlumnos').insertAdjacentHTML('afterend', boton_crear); 
         

        $('#tablaAsignarAlumnos').DataTable({
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
         
}

function limpiarTablaAlumnos(){

  $('#tablaAsignarAlumnos').dataTable().fnDestroy();
  document.getElementById('tablaAsignarAlumnos').remove(); 
}


function asignarAlumnoCurso(){
  var alumnoBox = document.getElementById('formAsignarAlumno').alumnos,
  alumnos_a_agregar = [],
  boton = event.target,
  dataRequest,
  url = '/alumno/agregarAlumnoCurso';

  
  for(var i = 0; i < alumnoBox.length; i++){
      if (alumnoBox[i].checked){
        alumnos_a_agregar[alumnos_a_agregar.length] = alumnoBox[i].value;
      }
  }

  dataRequest = {alumnos: alumnos_a_agregar,
                 id_curso: boton.dataset.value};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
        console.log(response);
        activarEmergente('emergenteAgregarAlumno');
    }else{  
      console.log(response);
      //mostrarModal('formAsignarMateria','La materia se creo exitosamente!','Crear Materia','emergenteAgregarMateria');
      activarEmergente('emergenteAgregarAlumno');
    }
  });
}


/////////////////CONFIRMAR ELIMINAR ALUMNO DE CURSO ///////////////////
function confirmDestroyAlumnoCurso(id_alumno, id_persona, id_curso){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Alumno de Curso</h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarAlumnoCurso('+id_alumno+', '+ id_curso +')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyAlumnoCurso(id_persona);
  console.log(btnDestroy);
}

function modalBodyAlumnoCurso(id_persona){
var url = '/personas/editar', respuesta,dataRequest,bModal;

  dataRequest = {id:id_persona};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
    bModal.insertAdjacentHTML('beforeend','<b> Legajo: '+response['legajo']+'</b><br>'+
                              '<b> Nombre: '+response['nombre_persona']+'</b><br>'+
                              '<b> Apellido: '+response['apellido_persona']+'</b><br>'
      )
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

///////////////// ELIMINAR ALUMNO DEL CURSO ////////////////////////
function eliminarAlumnoCurso(id_alumno,id_curso){
  var respuesta,
      url = '/alumno/eliminarAlumnoCurso',
      dataRequest,
      btn = event.target,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id_alumno:id_alumno,
                 id_curso: id_curso,
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

/////////////////////////// CREAR ALUMNO /////////////////////////////////////////////////////////
function listarCrearAlumno() {
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto,
  url = '/alumno/listar_alumnos_personal',
  formUpdate = document.getElementById('formAsignarAlumno');

  removeErrors('formCrearAlumno');
  
  document.getElementById('formCrearAlumno').innerHTML= '';
  try{
    document.getElementById('crearAlumno').remove();
    document.getElementById('cancelar').remove();
  }catch(error){}


  respuesta = ajaxRequest(url);
  respuesta.then(response => response.json())
  .then(function(response){
    legajo = '<label for="legajo_alumno">Legajo :</label>' +
              '<input type="text" class="form-control" name="legajo_alumno" placeholder="Legajo del alumno. Numero de 6 digitos entre 0 y 100.000" required/></textarea>'

    S_alumno = '<label for="alumno">Alumno :</label>' +
    '<select name="persona_asociada" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">';
            
        for(var i = 0;i < response['persona_alumno'].length; i++){
                id_alumno = response['persona_alumno'][i]['id'];
                nombre_alumno = response['persona_alumno'][i]['nombre_persona'];
                apellido_alumno = response['persona_alumno'][i]['apellido_persona'];
                S_alumno += '<option value= "'+ id_alumno +'">'+nombre_alumno +' '+apellido_alumno +'</option>';
          }

    S_tutor = '<label for="tutor">Responsable :</label>' +
    '<select name="persona_responsable" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">';
            
        for(var i = 0;i < response['persona_tutor'].length; i++){
              id_tutor = response['persona_tutor'][i]['id'];
              nombre_tutor = response['persona_tutor'][i]['nombre_persona'];
              apellido_tutor = response['persona_tutor'][i]['apellido_persona'];
              S_tutor += '<option value= "'+ id_tutor +'">'+nombre_tutor +' '+apellido_tutor +'</option>';
          }   

    emergenteCrearAlumno = "'emergenteCrear'"
    boton_crearAlumno = '<button type="submit" class="btn btn-primary" id="crearAlumno" onclick="crearAlumno();">Crear Alumno</button>';
    boton_cancelar = '<button type="reset" class="btn btn-primary" id="cancelar" onclick="activarEmergente('+ emergenteCrearAlumno +');">Cancelar</button>'

    document.getElementById('formCrearAlumno').insertAdjacentHTML('beforeend', legajo);
    document.getElementById('formCrearAlumno').insertAdjacentHTML('beforeend', S_alumno);    
    document.getElementById('formCrearAlumno').insertAdjacentHTML('beforeend', S_tutor);
    document.getElementById('formCrearAlumno').insertAdjacentHTML('afterend', boton_cancelar);
    document.getElementById('formCrearAlumno').insertAdjacentHTML('afterend', boton_crearAlumno);
    
        
    });
}
/////////////////////////////////////////////// CREAR ALUMNO /////////////////////////////////////////////////////////////////
function crearAlumno(){
  var btn = event.target,
  url = '/alumno/store',
  alumnoBox = document.getElementById('formCrearAlumno').persona_asociada,
  responsableBox = document.getElementById('formCrearAlumno').persona_responsable,
  legajoBox = document.getElementById('formCrearAlumno').legajo_alumno,
  alumno_a_crear,
  responsable_alumno,
  legajoAlumno,
  dataRequest;

  alumno_a_crear = alumnoBox.value;
  responsable_alumno = responsableBox.value;
  legajoAlumno = legajoBox.value;

  removeErrors('formCrearAlumno');

  dataRequest = {
    legajo_alumno:legajoAlumno,
    persona_asociada:alumno_a_crear,
    persona_tutor:responsable_alumno,
  }

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      if(response[0] == 1) {
        emergente = "'emergenteCrear'";
        console.log(response);
        //console.log(response[1][0]['id']);
        label = '<label id="labelExiste" for="alumno_existente">El legajo '+ legajoAlumno +' se encuentra dado de baja y puede estar asociado a otra persona que la seleccionada. Desea restaurarlo?</label>';
        boton_no = '<button id="Existe_no" type="reset" class="btn btn-primary" onclick="activarEmergente('+ emergente +');">NO</button>'        
        boton_si = '<button id="Existe_si" data-value="" id="agregarAlumno"type="submit" onclick="restaurarAlumno('+ response[1][0]['id'] +');"class="btn btn-primary">SI</button>'
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', label);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_si);
        document.getElementById("emergenteCrear").insertAdjacentHTML('beforeend', boton_no);
      }else {
        console.log(response);
        displayErrors(response,'formCrearAlumno');
      }         
    }else{
        console.log(response);
        emergente = "'emergenteUpdateAlumno'";
        document.getElementById("tablaAlumnos").insertRow(-1).innerHTML =
        '<td>'+ response[1] +'</td>' +
        '<td>'+ response[2]['nombre_persona'] +'</td>' +
        '<td>'+ response[2]['apellido_persona'] +'</td>' +
        '<td>' + legajoAlumno +'</td>' +
        '<td>'+ response[3]['nombre_persona'] +' '+ response[3]['apellido_persona'] +'</td>' +
        '<td>Promerdio</td>' +
        '<td>Asistencia</td>' +
        '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateAlumno(); " class="btn btn-primary">Editar</a></td>' +
        '<td><a data-value="'+ response[1] +'" onclick="confirmDestroyAlumno('+ response[1] +')" class="btn btn-danger">Eliminar</a></td>';
 
        mostrarModal('formCrearAlumno','El alumno se creo exitosamente!','Crear Alumno','emergenteCrear');
        //activarEmergente('emergenteCrearAlumno');

    }
  
  });

}

///////////////////////////////// EDITAR ALUMNO //////////////////////////////////////////////////////////////////////////////////

////////////////// ENVIAR DATOS ACTUALIZADOS ALUMNOS ////////////////////
function setUpdateAlumno(){
  var btn = event.target,
      btnUpdate = document.getElementsByClassName('toUpdate')[0],
      url = '/alumno/actualizar',
      formUpdate = document.getElementById('formUpdateAlumno');

  removeErrors('formUpdateAlumno');
  console.log(form.legajo_alumno.value);
  dataRequest = {
                 id:btn.dataset.value,
                 legajo_alumno:form.legajo_alumno.value,
                 persona_tutor:form.persona_tutor.value,
                };
  console.log('dataRequest', dataRequest);              
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      //btnUpdate.classList.remove("toUpdate");
      displayErrors(response,'formUpdateAlumno');
    }else{
      console.log(response);
      btnUpdate.classList.remove("toUpdate");
      emergente = "'emergenteUpdateAlumno'";
      //document.getElementsByClassName('modal')[0].remove();
      emergente = "'emergenteUpdateAlumno'";
      btnUpdate.parentNode.parentNode.innerHTML =
      '<td>'+ response[1] +'</td>' +
      '<td>'+ response[2]['nombre_persona'] +'</td>' +
      '<td>'+ response[2]['apellido_persona'] +'</td>' +
      '<td>' + form.legajo_alumno.value +'</td>' +
      '<td>'+ response[3]['nombre_persona'] +' '+ response[3]['apellido_persona'] +'</td>' +
      '<td>Promerdio</td>' +
      '<td>Asistencia</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateAlumno(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1] +'" onclick="confirmDestroyAlumno('+ response[1] +')" class="btn btn-danger">Eliminar</a></td>';
   

      mostrarModal('formUpdateAlumno','Modificado Correctamente!','Modificar Alumno','emergenteUpdateAlumno');
    }
    });

}
////////////////////DISPLAY DATA DE AlUMNOS //////
function updateAlumno(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdateAlumno'),
      id_update = btnUpdate.dataset.value,
      url = '/alumno/editar', respuesta,dataRequest,text;

      removeErrors('formUpdateAlumno');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          console.log('response', response);
          formUpdate.legajo_alumno.value = response['legajo_alumno'];
          formUpdate.persona_tutor.value = response['persona_tutor'];
          btnUpdate.classList.add("toUpdate");
          document.querySelector('#formUpdateAlumno [type="submit"]').dataset.value = response['id'];

        });
        console.log("editar alumno");
}

/////////////////////////////////////////// ELIMINAR ALUMNO /////////////////////////////////////////////////////////////////////////

/////////////////CONFIRMAR ELIMINAR ALUMNO ///////////////////
function confirmDestroyAlumno(id_alumno){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Alumno </h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarAlumno('+id_alumno+')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyAlumno(id_alumno);
  console.log(btnDestroy);
}

function modalBodyAlumno(id_alumno){
var url = '/alumno/editar', respuesta,dataRequest,bModal;

  dataRequest = {id:id_alumno};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
    bModal.insertAdjacentHTML('beforeend','<b> Legajo: '+ response['legajo_alumno'] +'</b><br>'+
                              '<b> Nombre: '+response['nombre_alumno']+'</b><br>'+
                              '<b> Apellido: '+response['apellido_alumno']+'</b><br>'
      )
      return response;
  });

}

///////////////// ELIMINAR ALUMNO ////////////////////////
function eliminarAlumno(id_alumno){
  var respuesta,
      url = '/alumno/destroy',
      dataRequest,
      btn = event.target,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id_alumno:id_alumno,
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

/////////////////////////////////// RESTAURAR ALUMNO //////////////////////////////////////////////
function restaurarAlumno(id_alumno){
  var btn = event.target,
  dataRequest,
  url = '/alumno/restaurarAlumno';

  dataRequest = {id_alumno: id_alumno};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
    } else {
      emergente = "'emergenteUpdateAlumno'";
      document.getElementById('labelExiste').remove();
      document.getElementById('Existe_no').remove();
      document.getElementById('Existe_si').remove();
      document.getElementById("tablaAlumnos").insertRow(-1).innerHTML =
      '<td>'+ response[1]['id'] +'</td>' +
      '<td>'+ response[2]['nombre_persona']+'</td>' +
      '<td>' + response[2]['apellido_persona'] +'</td>' +
      '<td>' + response[1]['legajo_alumno'] +'</td>' +
      '<td>' + response[3]['nombre_persona'] +' ' + response[3]['apellido_persona'] +'</td>' +
      '<td> Asistencia </td>' +
      '<td> Promedio </td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1]['id'] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyAlumno('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
      mostrarModal('formCrearAlumno','El alumno se dio nuevamente de alta!','Crear Alumno','emergenteCrear');
        
    }
 
  });    
}