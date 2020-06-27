function crearNoticia(){
  var form = event.target, url, data,fecha;

console.log("aca");
url = '/noticias/create';
data = {
    'descripcion_noticia' : form.descripcion_noticia.value,
    'titulo_noticia' : form.titulo_noticia.value
    }
respuesta = ajaxRequest(url,data);
respuesta.then(response => response.json())
.then(function(response){
  if(response[0] != 500){
    mostrarModal(form.id,'Ocurrio un error al crear la Noticia','Crear Noticia','emergenteCrear');
  }else{
    mostrarModal(form.id,'Noticia Creada Correctamente','Crear Noticia','emergenteCrear');
    fecha = new Date();
    fecha = fecha.getDate()+'-'+(fecha.getMonth()+1)+'-'+fecha.getFullYear();
    newNoticia = [
      '<div class="card card-body bg-light mt-3">'+
          '<div class="media">'+
              '<a class="pull-left" href="#"><img class="mr-3 img-thumbnail imgNoticias" src="/img/noticias.png"></a>'+
            '<div class="media-body">'+
              '<div class="col-md-9">'+
              '<div class="media-heading d-flex justify-content-md-center">'+
                '  <h4 class="align-self-center" style="float: left;">'+ form.titulo_noticia.value +'</h4><br>'+
              '</div>'+
              '</div>'+
                '<div class="col-md-3 text-center" style="float: right;">'+
                    document.getElementById("autorNoticia").outerHTML+
                  '<div class="col-sm-2 d-inline" style="float: right;">'+
                    '<a id="btnUpdate" data-value="' + response[1] +'" onclick="editRow();activarEmergente("emergenteUpdate");updateNoticia();" title="Editar" class="btn btn-primary glyphicon glyphicon-pencil"></a>'+
                    '<a class="btn btn-danger mt-1 glyphicon glyphicon-trash" title="Eliminar" onclick="deleteRow();confirmDestroyModalNoBody("'+ response[1] +'","eliminarNoticia","noticias")"></a>'+
                  '</div>'+
                '</div>'+
                '<p>'+form.descripcion_noticia.value+'</p>'+
                '<ul class="list-inline list-unstyled">'+
                    '<li class="list-inline-item">'+ document.getElementById("fechaNoticia").outerHTML +'</li>'+
               '</ul>'+
             '</div>'+
          '</div>'+
      '</div>'
    ];
    addRow("tablaNoticias",newNoticia);
  }
});
}

function eliminarNoticia(id,controlador){
  var respuesta,
      url = '/'+controlador+'/destroy',
      dataRequest,btn = event.target;

    dataRequest = {id:id};
    respuesta = ajaxRequest(url,dataRequest);
    respuesta.then(response => response.json())
    .then(function(response){
      if(response[0] != 500){
        console.log("error");
        noDeleteRow();//Desmarco la fila
        document.getElementsByClassName('modal')[0].remove();
        mostrarModal('tablaNoticias','No se puede Eliminar La Noticia Seleccionada!','Eliminar Permiso','null');
      }else{
        console.log("eliminando");
        confirmDeleteRow("tablaNoticias");
        document.getElementsByClassName('modal')[0].remove();
      }
    });
}

function updateNoticia(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/noticias/editar', respuesta,dataRequest,text,splitCuil;

      removeErrors('formUpdate');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          formUpdate.titulo_noticia.value = response['titulo_noticia'];
          formUpdate.descripcion_noticia.value = response['descripcion_noticia'];

          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];
        });
        console.log("editar persona");
}

////////////////// ENVIAR DATOS ACTUALIZADOS NOTICIA ////////////////////
function setUpdateNoticia(){
  var btn = document.getElementById('btnUpdate'),
      url = '/noticias/actualizar',
      formUpdate = document.getElementById('formUpdate'),newNoticia;

  removeErrors('formUpdate');

  dataRequest = { id:btn.dataset.value,
                  titulo_noticia:formUpdate.titulo_noticia.value,
                  descripcion_noticia:formUpdate.descripcion_noticia.value,
                  };
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
   .then(function(response){
     if(response[0] != '500'){
       console.log(response[0]);
       displayErrors(response,'formUpdate');
    }else{
      newNoticia = [
        '<div class="card card-body bg-light mt-3">'+
            '<div class="media">'+
                '<a class="pull-left" href="#"><img class="mr-3 img-thumbnail imgNoticias" src="/img/noticias.png"></a>'+
              '<div class="media-body">'+
                '<div class="col-md-9">'+
                '<div class="media-heading d-flex justify-content-md-center">'+
                  '  <h4 class="align-self-center" style="float: left;">'+ form.titulo_noticia.value +'</h4><br>'+
                '</div>'+
                '</div>'+
                  '<div class="col-md-3 text-center" style="float: right;">'+
                      document.getElementById("autorNoticia").outerHTML+
                    '<div class="col-sm-2 d-inline" style="float: right;">'+
                      '<a id="btnUpdate" data-value="' + btn.dataset.value +'" onclick="editRow();activarEmergente("emergenteUpdate");updateNoticia();" title="Editar" class="btn btn-primary glyphicon glyphicon-pencil"></a>'+
                      '<a class="btn btn-danger mt-1 glyphicon glyphicon-trash" title="Eliminar" onclick="deleteRow();confirmDestroyModalNoBody("'+ btn.dataset.value +'","eliminarNoticia","noticias")"></a>'+
                    '</div>'+
                  '</div>'+
                  '<p>'+form.descripcion_noticia.value+'</p>'+
                  '<ul class="list-inline list-unstyled">'+
                      '<li class="list-inline-item">'+ document.getElementById("fechaNoticia").outerHTML +'</li>'+
                 '</ul>'+
               '</div>'+
            '</div>'+
        '</div>'
      ];
      confirmEditRow("tablaNoticias",newNoticia);
      mostrarModal('formUpdate','Modificado Correctamente!','Modificar Noticia','emergenteUpdate');
      //javascript:location.reload();
    }
    });
}
