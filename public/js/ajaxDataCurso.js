///////////////// CREAR CICLO CURSO PARA CICLO ///////////////////////////////////
function agregarCursoCiclo(ciclo){
  var btn = event.target,
  id_alumno,
  nombre_alumno,
  texto,
  url = '/curso/agregarCursoCiclo',
  form = document.getElementById('formAgregarCursoCiclo');

  removeErrors('formAgregarCursoCiclo');
  //console.log(form.estados.value);
  dataRequest = {
    anio:ciclo['anio'],
    nombre_curso:form.curso.value,
    division:form.division.value,
    aula:form.aula.value,
    id_ciclo_lectivo:ciclo['id'],
  }
  console.log(dataRequest);

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log(response);
      displayErrors(response,'formAgregarCursoCiclo');
    }else{

      mostrarModal('formAgregarCursoCiclo','El curso se agrego correctamente!','Agregar Curso al Ciclo Lectivo','emergenteCrearCurso');
      javascript:location.reload();
    }
  });



}