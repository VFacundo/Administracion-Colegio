///////////////// CREAR CICLO CURSO PARA CICLO ///////////////////////////////////
function crearCursoCiclo(){
  var btn = event.target,
      form = btn.parentNode,
      dataRequest,
      url = '/curso/agregarCursoCiclo',
      respuesta,
      nuevaFila;

 
  //console.log(form.estados.value);
  dataRequest = {
    anio:form.anio.value,
    nombre:form.nombre.value,
  }
  console.log(dataRequest);

  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
    if(response[0] != 500){
      console.log("error");
      displayErrors(response,'formAltaCiclo');
       //btnDestroy.classList.remove("toDestroy");
    }else{

 

      activarEmergente('emergenteCrear');
    }
  });
  console.log(dataRequest);
}