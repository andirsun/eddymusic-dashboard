
<link rel="stylesheet" href="<? echo base_url() ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<div class="container-fluid py-2">
	<h2 id="titulo2">Administrador de paquetes de estudio de : </h2>
	<div class="container" id="titulo">
	</div>
	<div class="form-group row">
		<div class="col-sm-9">
			<select id="list-instrument-no-selected" class="form-control d-inline-block"></select>
		</div>
		<div class="col-sm-3">
			<button type="button" class="btn btn-block btn-success" id="addInstrument">
				Agregar instrumento
			</button>
		</div>
		<div class="col-12 p-0">
			<div class="alert alert-danger my-2" style="display: none;" id="msg-add-instrument">
				<h3 id="txt-add-instrument" class="text-center"></h3>
			</div>
		</div>	
	</div>
	<h6>instrumentos seleccionados</h6>
	<ul class="nav nav-tabs" id="list-instruments"> <!--Aqui se agregan dinamicamente los instrumentos en los tabs-->
	</ul>
	<div class="tab-content" id="tabContentInstruments">
	</div>
</div>
<div class="d-none">
	<ul>
		<li class="nav-item" id="item-instrument">
			<a class="nav-link cursor-pointer" data-toggle="tab" href="#" role="tab" aria-selected="false"></a>
		</li>
	</ul>
	<div class="tab-pane py-2 fade" id="tab-content-clone" role="tabpanel" aria-labelledby="profile-tab">
		<ul class="nav nav-pills mb-3" role="tablist" id="list">
			<li class="nav-item">
				<a class="nav-link active" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-selected="true">Paquetes</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="histroy-tab" is-click="false" data-toggle="tab" href="#history" role="tab" aria-selected="false">Registro de Clases</a>
			</li>
		</ul>
		<div class="tab-content" id="instrument-content-information">
			<div class="tab-pane fade show active" id="information" role="tabpanel">
				<form class="form-group" id="form1" addPackageInstrument>
					<div class="row">
						<fieldset class="form-group col-sm-3">
							<label>Numero de recibo</label>
							<input type="number" min="1" class="form-control" name="price" id="nRecibo" placeholder="Numero de recibo" required>
						</fieldset>		
						<fieldset class="form-group col-sm-3">
							<label>Concepto</label>
							<input type="text"  class="form-control" name="conceptoPaquete" id="conceptoPaquete" placeholder="Descripcion" >
						</fieldset>	
						<fieldset class="form-group col-sm-3">
							<div class="custom-control custom-checkbox mr-sm-2 d-flex align-items-end h-100">
								<input type="checkbox" class="custom-control-input" id="bono" name="bono">
								<label class="custom-control-label" for="bono">
									Bono: <span id="has-bono">No</span>
								</label>
							</div>
						</fieldset>
					</div>
					<div class="row">
						<fieldset class="form-group m-0 col-sm-3">
							<label>Tipo de descuento</label>
							<select id="discount" name="descuento" class="form-control" required>
								<option value="">--Seleccionar tipo--</option>
								<option value="0">Regular</option>
								<option value="1">Descuento especial</option>
								<option value="2">Media beca</option>
								<option value="3">Beca</option>
							</select>
						</fieldset>
						<fieldset class="form-group m-0 col-sm-3">
							<label>Medio de pago</label>
							<select id="medio" name="medio" class="form-control" required>
								<option value="">--Seleccionar medio--</option>
								<option value="0">Efectivo</option>
								<option value="1">Banco</option>
							</select>
						</fieldset>
						<fieldset class="form-group m-0 col-sm-2">
							<label for="">Numero de horas</label>
							<input type="number" min="0" class="form-control" id="hours" name="hours" placeholder="4,8,12,16,20,24,72" required>
						</fieldset>
						<div class=" form-group col-sm-1 ">
							<label for="">Accion</label>
							<button id="calcularPrecio" class="btn btn-block btn-warning align-self-end">
								Calcular
							</button>
						</div>
						<fieldset class="form-group m-0 col-sm-1" id="divPorcentaje">
							<label for="">Porcentaje</label>
							<input type="number" min="0" class="form-control" id="porcentaje" name="porcentaje" placeholder="numero" >
						</fieldset>
					</div>
					<div class="row mt-2">
						<fieldset class="form-group m-0 col-sm-2">
							<label>Precio</label>
							<input type="number" min="0" class="form-control" name="price" id="price"  required>
						</fieldset>
						<div class="col-sm-1 d-flex align-items-end">
							<h3 class="m-0 text-center" id="price-view">0</h3>
						</div>
						<fieldset class="form-group m-0 col-sm-2">
							<label>Pago</label>
							<select id="pago" name="pago" class="form-control" required>
								<option value="">--Seleccionar--</option>
								<option value="completo">Completo</option>
								<option value="abono">Abono</option>
								<option value="saldo">Saldo</option>
								
							</select>
						</fieldset>
						
						<div class="col-sm-2 d-flex">
							<button type="submit" class="btn btn-block btn-success align-self-end">
								Comprar paquete de horas
							</button>
						</div>
					</div>
					<div class="col-12">
						<div class="my-2 alert" id="msg-form" style="display: none;"></div>
					</div>
				</form>
				<h3>
					Listado de Paquetes Adquiridos: 
					<!-- <button type="button" class="btn btn-info btn-sm" id="btn-view-future-class">Ver clase futuras</button> -->
				</h3>
				<div class="row no-gutters">
					<div class="col-sm-9">
						<ul class="list-group" id="list-package"></ul>
						<h3 class="my-2">Horario de clases habituales del estudiante:</h3>
						<ul class="list-group" id="next-class"></ul>
					</div>
					<div class="col-sm-2">
						<div class="content-button-view-class-available">
							<button type="button" class="btn btn-sm btn-block btn-info" id="btn-see-class-available">
								<i class="far fa-bookmark"></i>
								Agendar clase
							</button>
						</div>
					</div>
				</div>
				<div class="alert alert-danger my-2" style="display: none;" id="msg-error-class-available">
					<h2 class="m-0">Ocurrio un error</h2>
				</div>
			</div>
			<div class="tab-pane fade" id="history" role="tabpanel">
				<form class="d-inline-block" id="form-history">
					<input type="hidden" id="idInstrument" value="0">
					<input type="hidden" id="idStudent" value="0">
					<div class="row no-gutters mb-2">
						<div class="col">
							<fieldset class="form-group m-0 px-2">
								<label for="" class="m-0" id="label-from">Desde</label>
								<input type="text" id="from" data-date="from" class="form-control">
							</fieldset>
						</div>
						<div class="col">
							<fieldset class="form-group m-0 px-2">
								<label class="m-0" for="">Hasta</label>
								<input type="text" id="to" data-date="to" class="form-control">
							</fieldset>
						</div>
						<div class="col d-flex align-items-end">
							<fieldset class="form-group m-0 px-2">
								<button type="submit" class="btn btn-sm btn-success">
									Generar
								</button>
							</fieldset>
						</div>
					</div>
				</form>
				<table class="table">
					<thead>
						<tr>
							<th>Fecha de clase</th>
							<th>Profesor</th>
							<th>Estado</th>
								<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="table-history">
						<tr>
							<th colspan="3">
								<h3 class="text-center">Historial</h3>
							</th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul>
		<li class="list-group-item" id="item-next-class">
			<div class="row">
				<div class="col-sm-5">
					Fecha: <span id="date"></span>
				</div>
				<div class="col-sm-3">
					Hora: <span id="hours"></span>
				</div>
				<?php if ($level==0 || $level==4): ?>
					<div class="col-sm-3 text-right" >
						<span id="removeClass" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></span>
					</div>
				<?php endif ?>
			</div>
		</li>
		<li class="list-group-item" id="item-package-clone">
			<div class="row">
				<div class="col">
					Horas: <span id="hours"></span>
				</div>
				<div class="col">
					Precio: <span id="price"></span>
				</div>
				<div class="col">
					Pago: <span id="pago"></span>
				</div>
				<div class="col">
					Descuento: <span id="discount"></span>
				</div>
				<div class="col">
					Porcentaje: <span id="porcentaje"></span>
				</div>
				<div class="col-4">
					Concepto: <span id="concept"></span>
				</div>
				<div class="col">
					Fecha: <span id="date"></span>
				</div>
			</div>
		</li>
	</ul>
	<div class="card my-2" card id="card-clone">
	  	<div class="card-body" card-body>
	  		<div class="row no-gutters">
	  			<div class="col-sm-10">
						<h5 class="card-title">
							<i class="fas fa-music icon-width"></i> Instrumento: <span id="name_instrument"></span>
						</h5>
						<p class="card-subtitle my-1">
							<i class="fas fa-users icon-width"></i> N. de estudiantes: <span id="n_students"></span>
						</p>
						<p class="card-subtitle my-1">
							<i class="fas fa-stopwatch icon-width"></i> Horas: <span id="n_hours"></span>
						</p>
						<p class="card-subtitle my-1">
							<i class="far fa-clock icon-width"></i> Dia de la semana: <span id="day"></span>
						</p>
						<p class="card-subtitle my-1">
							<i class="far fa-clock icon-width"></i> Hora de inicio: <span id="time"></span>
						</p>
						<div class="d-block" id="options-type">
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="general" name="type" value="0" class="custom-control-input" checked>
							  <label class="custom-control-label" for="general" data-option="0">General</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="bono" name="type" value="1" class="custom-control-input">
							  <label class="custom-control-label" for="bono" data-option="1">Bono</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							  <input type="radio" id="reprogramado" name="type" value="2" class="custom-control-input">
							  <label class="custom-control-label" for="reprogramado" data-option="2">Reprogramado</label>
							</div>
						</div>
	  			</div>
	  			<div class="col-sm-2 d-flex">
						<form id="formAgendClass" class="d-flex w-100">
							<input type="hidden" id="nDay" value="0">
							<input type="hidden" id="time_send" value="0">
							<input type="hidden" id="idInstrument" value="0">
							<input type="hidden" id="idClassHead" value="0">
			  				<input type="hidden" id="nHours" value="0">
			  				<input type="hidden" id="dateStart" value="">
			  				<button type="submit" id="addClassStudent" class="btn btn-block btn-success" style="font-size: 40px;">
			  					<i class="fas fa-check"></i>
			  				</button>
						</form>
	  			</div>
					<div id="content-date-calendar-class" style="display: none;">
						<fieldset class="form-group mb-0 mt-2" id="content-date">
							<label for="dateI" class="mb-1">Fecha: <span id="date-text"></span></label>
							<input type="text" class="form-control" data-calendar id="date-select-class" required/>
						</fieldset>
					</div>
	  		</div>
	  		<div class="my-2 alert" style="display: none;" id="msg-card-class">
	  			<h3 id="text-msg-card-class" class="text-center"></h3>
	  		</div>
	  	</div>
	</div>
  <table class="table" >
		<tbody>
			<tr id="trClone">
				<td id="dateClass">1</td>
				<td id="idProfesor">2</td>
				<td id="status">3</td>
				<td id="acciones">
					<?php if ($level==0 /*|| $level==4*/): ?>
						<div class="col-sm-3 text-right" >
							<span id="deleteClass" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></span>
						</div>
					<?php endif ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<script>
	var idUserStudent = '<? echo $idUser ?>';
</script>
<script src="<?echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?echo base_url() ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?echo base_url() ?>assets/js/admin/clases.js?<? echo time_unix(); ?>" type="text/javascript"></script>