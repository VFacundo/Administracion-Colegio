function listarMaterias(id_curso) {
  var btn = event.target,
  id_materia,
  nombre_materia,
  texto,
  url = '/materia/listar',
  formUpdate = document.getElementById('formAsignarMateria');

  removeErrors('formAsignarMateria');
  dataRequest = {nombre_curso:btn.dataset.value,
                };
  console.log(dataRequest); 
  document.getElementById('listaMaterias').innerHTML= '';
  try{
  	document.getElementById('boton_crear').remove();
  }catch(error){}
  

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
   	console.log(response);
    	for(var i = 0;i < response['materia_curso'].length; i++){
      			id_materia = response['materia_curso'][i]['id'];
      			nombre_materia = response['materia_curso'][i]['nombre'];    			
            texto = '<input type="checkbox" name="materias" value="'+ id_materia +'">' +
                '<label for="materias"> '+ nombre_materia +'</label><br>';
                document.getElementById('listaMaterias').insertAdjacentHTML('beforeend', texto);
    	}
        
        boton_crear = '<button data-value="'+ id_curso +'" id="boton_crear"type="submit" onclick="asignarMateriaCurso();"class="btn btn-primary">Agregar a curso</button>'
        document.getElementById('listaMaterias').insertAdjacentHTML('afterend', boton_crear);  
    });
}

function asignarMateriaCurso(){
	var materiasBox = document.getElementById('formAsignarMateria').materias,
	materias_a_agregar = [],
	boton = event.target,
	dataRequest,
	url = '/materia/agregarMateriaCurso';


	if (Array.isArray(materiasBox)){ //ESTO NO FUNCIONA
   
	for(var i = 0; i < materiasBox.length; i++){
			if (materiasBox[i].checked){
				materias_a_agregar[materias_a_agregar.length] = materiasBox[i].value;
			}
		}	
	}else {
    
		materias_a_agregar[0] = materiasBox.value;
	}

  console.log('materias_a_agregar', materias_a_agregar);
	dataRequest = {materias: materias_a_agregar, id_curso: boton.dataset.value};
  console.log('dataRequest', dataRequest);
	respuesta = ajaxRequest(url,dataRequest);
  	respuesta.then(response => response.json())
   	.then(function(response){
   	 if(response[0] != 500){
      	console.log("error");

      	displayErrors(response,'formAsignarMateria');
       //btnDestroy.classList.remove("toDestroy");
    }else{	
   		console.log(response);
   		activarEmergente('emergenteAgregarMateria');
    }
    });
}


function agregarHorario(){
var boton = event.target;
  horario =  '<div><label for="dias">Dias : </label>' +
                '<select name="hora_inicio" style= "border-radius: 5px; height: 30px;">'+
                   '<option value="lunes"> Lunes </option>'+
                   '<option value="martes"> Martes </option>'+
                   '<option value="miercoles"> Miercoles</option>' + 
                  ' <option value="jueves"> Jueves </option>'+
                  ' <option value="viernes"> Viernes</option>'+
                '</select>'+

                  '<label for="hora_inicio">Hora Inicio :</label>'+
                  '<select name="hora_inicio" style= "border-radius: 5px; height: 30px;">'+
                   '<option value= "13">13:00</option>'+
                   '<option value= "14">14:00</option>'+
                   '<option value= "15">15:10</option>'+
                   '<option value= "16">16:10</option>'+
                   '<option value= "17">17:15</option>'+
                '</select>'+

                '<label for="hora_fin">Hora Fin :</label>'+
                '<select name="hora_fin" style= "border-radius: 5px; height: 30px;">'+
                   '<option value= "14">14:00</option>'+
                   '<option value= "15">15:00</option>'+
                   '<option value= "16">16:10</option>'+
                   '<option value= "17">17:10</option>'+
                   '<option value= "18">18:15</option>'+
                '</select>'+

              '<button type="submit" class="btn btn-primary glyphicon glyphicon-remove" onclick=""></button>'+
              '</div>';
        
        
        document.getElementById('btn_mas').insertAdjacentHTML('beforebegin', horario);
}

function crearMateria(){
  var btn = event.target,
  url = '/materia/store';

  removeErrors('formCrearMateria');
  //console.log(form.estados.value);
  dataRequest = {
    nombre:form.nombre.value,
    carga_horaria:form.carga_horaria.value,
    programa_materia:form.programa_materia.value,
    fecha_creacion: '2005-05-20',
    curso_correspondiente:form.curso.value,
  }

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      if(response[0] == 1) {
        emergente = "'emergenteCrearMateria'";
        console.log(response);
        console.log(response[1][0]['id']);
        label = '<label id="labelExiste" for="ciclo_existente">'+ form.nombre.value  +' de '+ form.curso.value  +' se encuentra dado de baja. Desea restaurarlo?</label>';
        boton_no = '<button id="Existe_no" type="reset" class="btn btn-primary" onclick="activarEmergente('+ emergente +');">NO</button>'        
        boton_si = '<button id="Existe_si" data-value="" id="agregarAlumno"type="submit" onclick="restaurarMateria('+ response[1][0]['id'] +');"class="btn btn-primary">SI</button>'
        document.getElementById("emergenteCrearMateria").insertAdjacentHTML('beforeend', label);
        document.getElementById("emergenteCrearMateria").insertAdjacentHTML('beforeend', boton_si);
        document.getElementById("emergenteCrearMateria").insertAdjacentHTML('beforeend', boton_no);
      }else {
        console.log(response);
        displayErrors(response,'formCrearMateria');
      } 
    }else{
        console.log(response);
        emergente = "'emergenteUpdate'";
        document.getElementById("tablaMaterias").insertRow(-1).innerHTML =
        '<td>'+ response[1] +'</td>' +
        '<td>'+ form.nombre.value +'</td>' +
        '<td>'+ form.carga_horaria.value +'</td>' +
        '<td>' + form.programa_materia.value +'</td>' +
        '<td>' + response[2] +'</td>' +
        '<td>' + form.curso.value +'</td>' +
        '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
        '<td><a data-value="'+ response[1] +'" onclick="confirmDestroyMateria('+ response[1] +')" class="btn btn-danger">Eliminar</a></td>';

        mostrarModal('formCrearMateria','La materia se creo exitosamente!','Crear Materia','emergenteCrearMateria');


    }
  
  });
}



/////////////////CONFIRMAR ELIMINAR UNA MATERIA ///////////////////
function confirmDestroyMateria(id_materia){
var cModal, btnDestroy = event.target;

btnDestroy.classList.add("toDestroy");
document.body.insertAdjacentHTML('afterend','<div class="modal" tabindex="-1" role="dialog" style="display:block">'+
          '<div class="modal-dialog" role="document">'+
            '<div class="modal-content">'+
              '<div class="modal-header">'+
                '<h5 class="modal-title">Confirmar Eliminar Materia</h5>'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteModalD()">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
              '</div>'+
              '<div class="modal-body">'+
              '<b>La siguiente informacion sera Eliminada, desea continuar?</b><br>'+
              '<b></b><br>'+
              '</div>'+
              '<div class="modal-footer">'+
                '<button type="button" class="btn btn-primary" onclick="eliminarMateria('+ id_materia +')">Confirmar</button>'+
                '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="deleteModalD()">Cancelar</button>'+
              '</div>'+
              '</div>'+
             '</div>'+
            '</div>');
  modalBodyMateria(id_materia);
  console.log(btnDestroy);
}


function modalBodyMateria(id_materia){
var url = '/materia/editar', 
    respuesta,
    dataRequest,
    bModal;

  dataRequest = {id:id_materia};
  bModal = document.getElementsByClassName("modal-body")[0];
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    console.log('respuesta', response);
    bModal.insertAdjacentHTML('beforeend','<b> Materia: '+response['nombre']+'</b><br>'+
                              '<b> Curso: '+response['curso_correspondiente']+'</b><br>'
      )
      return response;
  });

}

///////////////// ELIMINAR MATERIA ////////////////////////
function eliminarMateria(id_materia){
  var respuesta,
      url = '/materia/destroy',
      dataRequest,
      btn = event.target,
      row,
      btnDestroy = document.getElementsByClassName("toDestroy")[0];
  console.log(btnDestroy);
  dataRequest = {id_materia:id_materia,
                }; 
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
    }else{
      btnDestroy.parentNode.parentNode.remove();
      btnDestroy.classList.remove("toDestroy");
      document.getElementsByClassName('modal')[0].remove();
      mostrarModal('tablaMaterias','La materia seleccionada fue dada de baja','Eliminar Materia','null');
    }
  });
}

///////////////// RESTAURAR MATERIA ////////////////////////
function restaurarMateria(id_materia){
  var btn = event.target,
  ciclo_a_restaurar,
  dataRequest,
  url = '/materia/restaurarMateria';

  dataRequest = {id_materia: id_materia};
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
      document.getElementById("tablaMaterias").insertRow(-1).innerHTML =
      '<td>'+ response[1]['id'] +'</td>' +
      '<td>'+ response[1]['nombre']+'</td>' +
      '<td>' + response[1]['carga_horaria'] +'</td>' +
      '<td>' + response[1]['programa_materia'] +'</td>' +
      '<td>' + response[1]['estado_materia'] +'</td>' +
      '<td>' + response[1]['curso_correspondiente'] +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1]['id'] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1]['id'] +'" onclick="confirmDestroyMateria('+ response[1]['id'] +')" class="btn btn-danger">Eliminar</a></td>';
      mostrarModal('formCrearMateria','La materia se dio nuevamente de alta!','Crear Materia','emergenteCrearMateria');
        
    }
 
  });    
}

////////////////// ENVIAR DATOS ACTUALIZADOS MATERIA ////////////////////
function setUpdateMateria(){
  var btn = event.target,
      btnUpdate = document.getElementsByClassName('toUpdate')[0],
      url = '/materia/actualizar',
      formUpdate = document.getElementById('formUpdateMateria');

  removeErrors('formUpdateMateria');
  dataRequest = {
                 id:btn.dataset.value,
                 nombre:form.nombre.value,
                 carga_horaria:form.carga_horaria.value,
                 programa_materia:form.programa_materia.value,
                 estado_materia: form.estado_materia.value,
                 curso_correspondiente:form.curso.value,
                };
  console.log('dataRequest', dataRequest);              
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != 500){
      //btnUpdate.classList.remove("toUpdate");
      displayErrors(response,'formUpdateMateria');
    }else{
      console.log(response);
      btnUpdate.classList.remove("toUpdate");
      emergente = "'emergenteUpdateMateria'";
      //document.getElementsByClassName('modal')[0].remove();
      btnUpdate.parentNode.parentNode.innerHTML =
      '<td>'+ response[1] +'</td>' +
      '<td>'+ form.nombre.value +'</td>' +
      '<td>'+ form.carga_horaria.value +'</td>' +
      '<td>' + form.programa_materia.value +'</td>' +
      '<td>'+ response[2] +'</td>' +
      '<td>' + form.curso.value +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateMateria(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1] +'" onclick="confirmDestroyMateria('+ response[1] +')" class="btn btn-danger">Eliminar</a></td>';

      mostrarModal('formUpdateMateria','Modificado Correctamente!','Modificar Materia','emergenteUpdateMateria');
    }
    });

}
////////////////////DISPLAY DATA DE MATERIA //////
function updateMateria(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdateMateria'),
      id_update = btnUpdate.dataset.value,
      url = '/materia/editar', respuesta,dataRequest,text;

      removeErrors('formUpdateMateria');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          console.log(response);
          formUpdate.nombre.value = response['nombre'];
          formUpdate.carga_horaria.value = response['carga_horaria'];
          formUpdate.programa_materia.value = response['programa_materia'];
          formUpdate.estado_materia.value = response['estado_materia'];
          formUpdate.curso.value = response['curso_correspondiente'];
          btnUpdate.classList.add("toUpdate");
          console.log(btnUpdate);
          document.querySelector('#formUpdateMateria [type="submit"]').dataset.value = response['id'];

        });
        console.log("editar materia");
}
