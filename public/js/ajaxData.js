function updateUser_backup(){
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
        formUpdate.name.value = respuesta['name'];
        formUpdate.email.value = respuesta['email'];
        formUpdate.id_persona.value = respuesta['id_persona'];
        console.log('Request successful', respuesta);
      })
    .catch(function(error) {
        console.log(error);
      });

  console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
}

function getPersona(id_persona){
var url = '/personas/getdata', respuesta,dataRequest;

  dataRequest = {id:id_persona};
  respuesta = ajaxRequest(url,dataRequest);
  respuesta.then(response => response.json())
  .then(function(response){
      return response;
  });

}

function setUpdateUser(){
  var btn = event.target,
      url = '/usuarios/actualizar',
      formUpdate = document.getElementById('formUpdate');

  removeErrors('formUpdate');
  dataRequest = {id:btn.dataset.value,
                  name:formUpdate.name.value,
                  email:formUpdate.email.value,
                  id_persona:formUpdate.id_persona.value};
  console.log(dataRequest);
  respuesta = ajaxRequest(url,dataRequest);
  console.log(respuesta);
  respuesta.then(response => response.json())
   .then(function(response){
      displayErrors(response,'formUpdate');
    });
}

function removeErrors(formName){
  try{
    form = document.getElementById(formName);
    divPadre = form.parentNode;
    divHijos = divPadre.querySelectorAll(".alert.alert-danger");

    for (var i = 0; i < divHijos.length; i++) {
      divPadre.removeChild(divHijos[i]);
    }
  }catch(error){
    console.log(error);
  }

}

function displayErrors(arrayErrores,formName){
var div, ul,li;

  div = document.createElement("div");
  ul = document.createElement("ul");
  div.classList.add("alert");
  div.classList.add("alert-danger");
  div.appendChild(ul);

for(var i = 0; i < arrayErrores.length ; i++){
  li = document.createElement("li");
  li.innerHTML = arrayErrores[i];
  ul.appendChild(li);
}

document.getElementById(formName).parentNode.appendChild(div);
}

function updateUser(){
  var btnUpdate = event.target,
      formUpdate = document.getElementById('formUpdate'),
      id_update = btnUpdate.dataset.value,
      url = '/usuarios/editar', respuesta,dataRequest,text;

      removeErrors('formUpdate');
      dataRequest = {id:id_update}; //Datos a Enviar
      respuesta = ajaxRequest(url,dataRequest)
      respuesta.then(response => response.json())
        .then(function(response){
          formUpdate.name.value = response['name'];
          formUpdate.email.value = response['email'];
          formUpdate.id_persona.value = response['id_persona'];
          document.querySelector('#formUpdate [type="submit"]').dataset.value = response['id'];
        });
}

function ajaxRequest(url,dataRequest){
  var csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    return  fetch(url, {
     headers: {
       "Content-Type": "application/json",
       "Accept": "application/json, text-plain, */*",
       "X-Requested-With": "XMLHttpRequest",
       "X-CSRF-TOKEN": csrf_token
      },
     method: 'post',
     credentials: "same-origin",
     body: JSON.stringify(
       dataRequest
     )
   })
 }
