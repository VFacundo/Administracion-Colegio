function listarAlumnos() {
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto,
  url = '/alumno/listar',
  formUpdate = document.getElementById('formAsignarAlumno');

  removeErrors('formAsignarAlumno');
  dataRequest = {curso_id:btn.dataset.value,
                };
  console.log(dataRequest); 
  document.getElementById('listaAlumnos').innerHTML= '';
  try{
  	document.getElementById('agregarAlumno').remove();
  }catch(error){}
  

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
   	console.log(response);
    texto = '<select name="alumnos" style= "border-radius: 5px; height: 30px; width: -webkit-fill-available;">';
            ;
        for(var i = 0;i < response['alumnos'].length; i++){
                id_alumno = response['alumnos'][i]['id'];
                nombre_alumno = response['alumnos'][i]['nombre_persona'];
                apellido_alumno = response['alumnos'][i]['apellido_persona'];
                texto += '<option value= "'+ id_alumno +'">'+nombre_alumno +' '+apellido_alumno +'</option>';
          }    
                document.getElementById('listaAlumnos').insertAdjacentHTML('beforeend', texto);
        
        boton_agregarAlumno = '<button data-value="'+ id_alumno +'" id="agregarAlumno"type="submit" onclick=""class="btn btn-primary">Agregar a curso</button>'
        document.getElementById('listaAlumnos').insertAdjacentHTML('afterend', boton_agregarAlumno);
    });
}