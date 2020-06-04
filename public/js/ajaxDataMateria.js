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