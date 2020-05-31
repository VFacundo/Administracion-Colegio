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

	if (Array.isArray(materiasBox)){

		for(var i = 0; i < materiasBox.length; i++){
			if (materiasBox[i].checked){
				materias_a_agregar[materias_a_agregar.length] = materiasBox[i].value;
			}
		}	
	} else {
		materias_a_agregar[0] = materiasBox.value;
	}

	dataRequest = {materias: materias_a_agregar, id_curso: boton.dataset.value};
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