



<div class="container-fluid py-2">
  <h1 class="h2">Regristro de Progresos de los estudiantes</h1>
  
  <ul class="nav nav-tabs" id="list-instruments"> <!--Aqui se agregan dinamicamente los instrumentos en los tabs-->
  </ul>
  <div class="tab-content" id="tabContentInstruments">
  </div>
</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-1">
    </div>
    <div class="col-10">

      <div class="owl-carousel owl-theme">
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/canto.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Canto</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/bateria.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Bateria</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/Bajo.png" class="card-img-top" alt="...">
            <h4 class="card-title">Bajo</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/guitarraAcustica.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Guit. Acustica</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/guitarraElectrica.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Guit. Electrica</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/piano.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Piano</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/percusion.jpg" class="card-img-top" alt="...">
            <h4 class="card-title">Percusion</h4>
        </div>
        <div class="shadow p-2 mb-3 bg-white rounded">
          <img src="<?echo base_url() ?>assets/images/violin.png" class="card-img-top" alt="...">
            <h4 class="card-title">Violin</h4>
        </div>

      </div>
    </div>
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
<script src="<?echo base_url() ?>assets/plugins/carousel/dist/owl.carousel.min.js?<?echo time_unix(); ?>"></script>
