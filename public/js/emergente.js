function activarEmergente(idElement) {
  var btnEditar = document.getElementById(idElement),
  divForm = document.getElementById(idElement),
  style = divForm.style.display,
  emergenteStyle = document.createElement('style');
    if(style == 'block'){
      divForm.classList.remove('emergenteActiva');
      divForm.style.display = 'none';
    }else {
      divForm.style.display='block';
      divForm.classList.add('emergenteActiva');
      //emergenteStyle.innerHTML =
        //'#'+idElement+
        //'border: black 2px solid;'+
        //'animation-name: zoom;'+
        //'animation-duration: 0.6s;'+
        //'position: fixed;'+
        //'z-index: 1;'+
        //'min-width: 80vw;'+
        //'max-width: 50vw;'+
        //'background-color: #f7faf2f7;'+
        //'align-self: auto;'+
        //'top: 20%;}';

      //divForm.appendChild(emergenteStyle);
    }
  console.log('editando..');
}
