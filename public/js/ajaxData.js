function updateUser(){
//  var btnUpdate = document.getElementById('btnUpdate'),
//      xhr = new XMLHttpRequest(),
//      formData = new FormData();
//      console.log("gola")
//      formData.append("id",btnUpdate.dataset.value);
//      xhr.open('POST', 'http://localhost/usuarios/edit');
//          xhr.onload = function() {
//          dataList.innerHTML = xhr.responseText;
//          console.log(xhr.responseText);
//          }
//      xhr.send(formData);
//      console.log(formData);
var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    btnUpdate = document.getElementById('btnUpdate'),
    formUpdate = document.getElementById('formUpdate'),
    id_update = btnUpdate.dataset.value,
    url = '/usuarios/editar', respuesta;

    fetch(url, {
   headers: {
     "Content-Type": "application/json",
     "Accept": "application/json, text-plain, */*",
     "X-Requested-With": "XMLHttpRequest",
     "X-CSRF-TOKEN": csrf_token
    },
   method: 'post',
   credentials: "same-origin",
   body: JSON.stringify({
     id: id_update
   })
  })
    .then(function(data) {
      return data.text();
    })
    .then(function(text) {
      respuesta = JSON.parse(text);
      formUpdate.legajo.value = respuesta['legajo'];
      formUpdate.username.value = respuesta['username'];
      formUpdate.mail.value = respuesta['mail'];
      formUpdate.id_persona.value = respuesta['id_persona'];
      console.log('Request successful', respuesta);
    })
  .catch(function(error) {
      console.log(error);
    });

console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
}
