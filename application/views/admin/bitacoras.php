<div class="container-fluid py-2">
  <h1 class="h2">Regristro de Progresos de los estudiantes</h1>
  <ul class="nav nav-tabs" id="list-instruments"> <!--Aqui se agregan dinamicamente los instrumentos en los tabs-->
  </ul>
  <div class="tab-content" id="tabContentInstruments">
  </div>
</div>

<div class="container-fluid py-2 mt-2 mb-5 shadow p-3 mb-5 bg-white rounded" id="contenido">
  <table  class="table table-borderless table-hover table-responsive-sm" id="tablaBitacoras" >
      <thead>
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Nombre Estudiante</th>
          <th scope="col">Profesor Encargado</th>
          <th scope="col">Instrumento</th>
          <th scope="col">Bitacora</th>
        </tr>
      </thead >
      <tbody >
        <tr id="cuerpoTabla">
          <th scope="row" id="fecha"></th>
          <td id="estudiante"></td>
          <td id="profesor"></td>
          <td id="instrumento"></td>
          <td id="bitacora"></td>
        </tr>  
      </tbody>
    </table>
</div>
<div class="d-none">
  <ul>
		<li class="nav-item" id="item-instrument">
			<a class="nav-link cursor-pointer" data-toggle="tab" href="#" role="tab" aria-selected="false"></a>
		</li>
	</ul>
</div>


<script src="<?echo base_url() ?>assets/js/admin/bitacora.js?<?echo time_unix(); ?>"></script>