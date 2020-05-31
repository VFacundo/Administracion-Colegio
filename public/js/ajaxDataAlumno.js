function listarAlumnos(id_curso) {
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto,
  url = '/alumno/listar',
  formUpdate = document.getElementById('formAsignarAlumno');

  removeErrors('formAsignarAlumno');
  dataRequest = {curso_id:btn.dataset.value,
                };
  document.getElementById('listaAlumnos').innerHTML= '';
  try{
  	document.getElementById('agregarAlumno').remove();
  }catch(error){}
  

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    texto = '<select name="alumnos" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">';
            ;
        for(var i = 0;i < response['alumnos'].length; i++){
                id_alumno = response['alumnos'][i]['id'];
                nombre_alumno = response['alumnos'][i]['nombre_persona'];
                apellido_alumno = response['alumnos'][i]['apellido_persona'];
                texto += '<option value= "'+ id_alumno +'">'+nombre_alumno +' '+apellido_alumno +'</option>';
          }    
                document.getElementById('listaAlumnos').insertAdjacentHTML('beforeend', texto);
        
        boton_agregarAlumno = '<button data-value="'+ id_curso +'" id="agregarAlumno"type="submit" onclick="asignarAlumnoCurso();"class="btn btn-primary">Agregar a curso</button>'
        document.getElementById('listaAlumnos').insertAdjacentHTML('afterend', boton_agregarAlumno);
    });
}

function asignarAlumnoCurso(){
  var alumnoBox = document.getElementById('formAsignarAlumno').alumnos,
  alumno_a_agregar,
  boton = event.target,
  dataRequest,
  url = '/alumno/agregarAlumnoCurso';

  alumno_a_agregar = alumnoBox.value;

  dataRequest = {id_alumno: alumno_a_agregar, id_curso: boton.dataset.value};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log(response);
    activarEmergente('emergenteAgregarAlumno');
  });
 
    
    
}


/////////////////CONFIRMAR ELIMINAR ALUMNO DE CURSO ///////////////////
function confirmDestroyAlumno(id_alumno, id_persona, id_curso){
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
  modalBodyAlumno(id_persona);
  console.log(btnDestroy);
}

function modalBodyAlumno(id_persona){
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
      url = '/alumno/destroy',
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
