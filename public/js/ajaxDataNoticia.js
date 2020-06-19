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
              '<div class="media-heading">'+
          		'<h4 style="float: left;">'+form.titulo_noticia.value+'</h4>'+
                '<p class="text-lg-right" style="float: right;">Autor: </p></div>'+
                '<p style="clear:right">'+form.descripcion_noticia.value+'</p>'+
                '<ul class="list-inline list-unstyled">'+
        			      '<li class="list-inline-item"><span><i class="glyphicon glyphicon-calendar"></i>'+ fecha +'</span></li>'+
      			   '</ul>'+
             '</div>'+
          '</div>'+
      '</div>'
    ];
    addRow("tablaNoticias",newNoticia);
  }
});
}
