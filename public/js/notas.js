function disabledNotas(trimestre){
  var primerTrimestre = document.getElementsByClassName("primer_trimestre"),
      segundoTrimestre = document.getElementsByClassName("segundo_trimestre"),
      tercerTrimestre = document.getElementsByClassName("tercer_trimestre");

  if(trimestre == "primer_trimestre"){
    for (var i = 0; i < segundoTrimestre.length; i++) {
      segundoTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }

    for (var i = 0; i < tercerTrimestre.length; i++) {
      tercerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }
  }

  if(trimestre == "segundo_trimestre"){
    for (var i = 0; i < primerTrimestre.length; i++) {
      primerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }

    for (var i = 0; i < tercerTrimestre.length; i++) {
      tercerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }
  }

  if(trimestre == "tercer_trimestre"){
    for (var i = 0; i < primerTrimestre.length; i++) {
      primerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }

    for (var i = 0; i < segundoTrimestre.length; i++) {
      segundoTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }
  }

  if(trimestre == "finalizado"){
    for (var i = 0; i < primerTrimestre.length; i++) {
      primerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }

    for (var i = 0; i < segundoTrimestre.length; i++) {
      segundoTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }

    for (var i = 0; i < tercerTrimestre.length; i++) {
      tercerTrimestre[i].getElementsByTagName("input")[0].disabled = true;
    }
  }

}

function limpiarError(){
  var errores = document.getElementsByClassName("error-input");

  for (var i = 0; i < errores.length; i++) {
    errores[i].classList.remove("error-input");
  }
}

function verificarNotas(trimestre){
  var trimestre = document.getElementsByClassName(trimestre), nota,error = false;
    for (var i = 0; i < trimestre.length; i++) {
      nota = trimestre[i].getElementsByTagName("input")[0].value;
      if((nota == "") || (nota<=0) || (nota>10)){
        trimestre[i].getElementsByTagName("input")[0].classList.add("error-input");
        error = true;
        console.log(error);
      }
    }
  return error;
}

function guardarNotas(trimestre){
  var primerTrimestre = document.getElementsByClassName("primer_trimestre"),
      segundoTrimestre = document.getElementsByClassName("segundo_trimestre"),
      tercerTrimestre = document.getElementsByClassName("tercer_trimestre"),
      bodyNotas = document.getElementById("notasAlumnos"),
      rowNotas = bodyNotas.getElementsByTagName("tr"),arrayNotas = new Array();

limpiarError();

if(!verificarNotas(trimestre)){
    for (var i = 0; i < rowNotas.length; i++) {
      var id_alumno, concepto,evaluacion,tp,trim,arrayAlumno;
        id_alumno = rowNotas[i].id;
        concepto = rowNotas[i].getElementsByClassName(trimestre)[0].getElementsByTagName("input")[0].value;
        evaluacion = rowNotas[i].getElementsByClassName(trimestre)[1].getElementsByTagName("input")[0].value;
        tp = rowNotas[i].getElementsByClassName(trimestre)[2].getElementsByTagName("input")[0].value;
        trim = rowNotas[i].getElementsByClassName(trimestre)[3].getElementsByTagName("input")[0].value;

        arrayAlumno = {
          id_alumno: id_alumno,
          concepto: concepto,
          evaluacion: evaluacion,
          tp: tp,
          trim: trim,
        }
        arrayNotas.push(arrayAlumno);
        console.log(arrayNotas);
    }
  }
}
