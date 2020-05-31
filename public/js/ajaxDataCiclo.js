////////////////// ENVIAR DATOS ACTUALIZADOS CICLO ////////////////////
function setUpdateCiclo(){
  var btn = event.target,
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
      tnUpdate.classList.remove("toUpdate");
      displayErrors(response,'formUpdate');
    }else{
      btnUpdate.classList.remove("toUpdate");
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
 
  //console.log(form.estados.value);
  dataRequest = {
    anio:form.anio.value,
    nombre:'Ciclo Lectivo ' + form.anio.value,
  }
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      displayErrors(response,'formAltaCiclo');
    }else{
      console.log(response);
      emergente = "'emergenteUpdate'";
      document.getElementById("tablaCiclos").insertRow(-1).innerHTML =
      '<td>'+ response[1] +'</td>' +
      '<td>'+ form.anio.value +'</td>' +
      '<td>Ciclo Lectivo ' + form.anio.value +'</td>' +
      '<td><a id="btnUpdate" data-value="'+ response[1] +'" onclick="activarEmergente('+ emergente +');  updateCiclo(); " class="btn btn-primary">Editar</a></td>' +
      '<td><a data-value="'+ response[1] +'" href="curso/'+ response[1] +'" class= "btn btn-primary">Ver Cursos</a></td>' +
      '<td><a data-value="'+ response[1] +'" onclick="" class="btn btn-danger">Eliminar</a></td>';
      mostrarModal('formAltaCiclo','El ciclo lectivo se creo exitosamente!','Crear Ciclo Lectivo','emergenteCrear');
    }
  });
}


