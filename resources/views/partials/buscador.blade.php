<div class="col-sm-10">
  <nav class="navbar">
    <a class="navbar-brand">{{$section}}</a>
    <form class="form-inline" onSubmit="return false;">
      <input class="form-control mr-sm-2" id="searchbox" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-success my-2 my-sm-0 glyphicon glyphicon-search"></button>
    </form>

    <script>
      $(document).ready(function() {
      var dataT = $('#{{$tableId}}').dataTable({
       "oLanguage": {
         "sInfo": "Se muestran de _START_ a _END_ de _TOTAL_ {{$section}}",
         "sZeroRecords": "No se encontraron Resultados",
         "sInfoEmpty": "No se encontraron Registros para Mostrar",
         "oPaginate": {
           "sNext": "Siguiente",
            "sPrevious": "Anterior"
         },
       }
     });
     $("#searchbox").keyup(function() {
         dataT.fnFilter(this.value);
     });
      });
    </script>

  </nav>
</div>
