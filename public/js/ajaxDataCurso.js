///////////////// CREAR CICLO CURSO PARA CICLO ///////////////////////////////////
function agregarCursoCiclo(anio_ciclo){
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto,
  url = '/curso/agregarCursoCiclo',
  form = document.getElementById('formAgregarCursoCiclo');

  //console.log(form.estados.value);
  console.log(anio_ciclo);
  dataRequest = {
    anio:anio_ciclo,
    curso:form.curso.value,
    division:form.division.value,
    aula:form.aula.value,
  }
  console.log(dataRequest);

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
  if(response[0] != 500){
    displayErrors(response,'formAgregarCursoCiclo');
  }else{
  //mostrarModal('formAgregarCursoCiclo','Modificado Correctamente!','Modificar Ciclo Lectivo','emergenteCrear');
   
    }
    });


}