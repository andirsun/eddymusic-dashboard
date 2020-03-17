<?php 
	$day = date('N') - 1;
	$week_start = date('Y-m-d', strtotime('-'.$day.' days')); 
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"> -->
<link rel="stylesheet"
	href="<?php echo base_url() ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<style>
	.table-responsive form .bootstrap-datetimepicker-widget.dropdown-menu {
		width: auto !important;
		min-width: 19rem !important;
		top: auto;
		bottom: auto !important;
		left: auto !important;
		right: auto !important;
		position: relative !important;
	}
</style>
<div class="container position-relative mt-2 mb-5 shadow p-3 mb-5 bg-white rounded">
	
		
			<div class="d-flex justify-content-between flex-wrap py-2" id="control-week">
				<div class="d-inline-block">
					<button type="button" id="prevWeek" btn-week="prev" class="btn btn-sm btn-info">
						<i class="fas fa-arrow-left"></i> Ant
					</button>
					<span id="prevWeekDay">--</span>
				</div>
				<fieldset class="form-group my-2 mx-" style="width:225px;">
					<input type="text" class="form-control text-center" id="datepicker">
				</fieldset>
				<div class="d-inline-block">
					<span id="nextWeekDay">--</span>
					<button type="button" id="nextWeek" btn-week="next" class="btn btn-sm btn-info">
						Sig <i class="fas fa-arrow-right"></i>
					</button>
				</div>
			</div>
			<div class="alert alert-danger text-center" id="alert-msg-datepicker-calendar" style="display: none;">
				<span>Error de datos</span>
			</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr id="days-of-week">
							<th>Hora</th>
							<th data-position="1" class="text-center">LUNES <span id="date_number"></span></th>
							<th data-position="2" class="text-center">MARTES <span id="date_number"></span></th>
							<th data-position="3" class="text-center">MIERCOLES <span id="date_number"></span></th>
							<th data-position="4" class="text-center">JUEVES <span id="date_number"></span></th>
							<th data-position="5" class="text-center">VIERNES <span id="date_number"></span></th>
							<th data-position="6" class="text-center">SABADO <span id="date_number"></span></th>
						</tr>
					</thead>
					<tbody id="tbody-schedule" class="list-schedule">
					</tbody>
				</table>
			</div>
			<div class="loader-schedule" id="loader-schedule" style="display: ;">
				<h2 class="m-0 d-inline-block txt">
					<i class="fa fa-spin fa-spinner"></i> Cargando horario
				</h2>
			</div>


	

</div>
<!-- Modal para el boton de asignacion de clases, este se debe replicar con -->
<button type="hidden" hidden data-toggle="modal" data-target="#clases" id="btnClases"></button>
<div class="modal fade" id="clases" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Asignacion Clases</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formAddHeadClass" class="mb-4">
					<input type="hidden" id="instrumentId" value="0">
					<div class="row">

						<div class="col-sm-12 mb-2">
							<input type="checkbox" class="head-form" id="armor-plating">
							<label for="armor-plating" class="armor-label">
								Blindar:
								<i class="fas fa-shield-alt" id="armor-plating"></i>
							</label>
						</div>

						<div class="col-sm-3 d-inline-flex align-items-end">
							<fieldset class="form-group w-100 m-0">
								<label for="list-instrument-select">Instrumento</label>
								<select id="list-instrument-select" class="form-control" required></select>
							</fieldset>
						</div>


						<div class="col-sm-3 d-inline-flex align-items-end">
							<fieldset class="form-group m-0">
								<label for="dateI">Fecha</label>
								<input type="text" class="form-control" id="dateformAddHeadClass" required />
							</fieldset>
						</div>


						<div class="col-sm-3 d-inline-flex align-items-end">
							<fieldset class="form-group m-0">
								<label for="HorasI">Horas</label>
								<div class="form-control">
									<i class="far fa-calendar-alt"></i>
									<span id="HorasformAddHeadClass"></span>
								</div>
							</fieldset>

						</div>

						<div class="col-sm-1 d-inline-flex align-items-end mt-2">
							<button type="submit" class="btn btn-block btn-success">
								Crear
							</button>
						</div>

					</div>

					<div class="alert my-2" style="display: none;" id="msgHeadClass">
						<h2 class="text-center m-0" id="text-msg"></h2>
					</div>
				</form>
				<div class="accordion" id="accordionList">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--Fin modal para asignar las clases-->

<div class="d-none">

	<button type="button" class="btn" data-asign="true" id="btnAsignClone"></button>
	<div class="card" style="overflow: unset;" card id="cardClone">
		<div class="card-header">
			<h2 class="mb-0 inline-block">
				<button class="btn text-dark btn-outline-light" type="button" id="btnHeadClass" data-toggle="collapse"
					data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				</button>
				<span class="float-right">

					<input type="checkbox" id="armor-plating" class="armor-input">
					<label for="armor-plating" class="armor-label tab-class">
						Blindar:
						<i class="fas fa-shield-alt" id="armor-plating"></i>
					</label>

					<div class="alert alert-danger text-center" style="display: none;" id="msg-alert-blocked">
						Ups.. Hubo un Error al realizar peticion
					</div>

				</span>
				<span class="float-right">
					<?php if ($level==0 || $level==4): ?>
					<button type="button" id="botonBorrarClase" value=""
						class="btn btn-outline-danger mr-2">Borrar-Admin</button>
					<?php endif ?>
				</span>
			</h2>
		</div>
		<div id="collapseOne" class="collapse" data-parent="#accordionList">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-left" width="60%">Estudiante</th>
								<th class="text-center" width="10%">Horas</th>
								<th class="text-center" width="10%">Estado</th>
								<th class="text-center" width="20%">Profesor</th>
								<!-- <th class="text-right" width="20%">Accion</th> -->
							</tr>
						</thead>
						<tbody id="tbody-list-students">
						</tbody>
					</table>
				</div>
				<div class="alert" style="display: none;" id="msg-card">
					<h2 id="text-msg"></h2>
				</div>
			</div>
		</div>
	</div>
	<table>
		<tr id="trStudentClone">
			<td class="align-top" id="name-student"></td>
			<td class="align-top text-center" id="hour-class"></td>
			<td class="align-top text-center">
				<fieldset class="form-group m-0">
					<form id="formSendStateStudent" class="d-flex">
						<select class="custom-select" id="select-status-student" style="min-width: 17rem;">
							<option value="">-- Asignar estado --</option>
							<option value="1">Asistio</option>
							<option value="2">Falto</option>
							<option value="3">Cancelo</option>
						</select>
						<button type="submit" class="btn btn-success">
							<i class="fa fa-check"></i>
						</button>
					</form>
					<form id="reasigndateform" class="mt-2 position-relative" style="display: none;">
						<label for="">Asignar fecha</label>
						<button type="button" class="btn btn-sm btn-danger float-right" id="btn-close-form-asign-date">
							<i class="fa fa-times"></i>
						</button>
						<input type="text" class="form-control" name="date" id="date-reasign" required>
						<select name="time" class="form-control" required>
							<?php for ($i = 8; $i<=19; $i++): ?>
							<option value="<?php echo $i<10? " 0".$i : $i ?>:00">
								<?php echo $i<10? "0".$i : $i ?>:00</option>
							<?php endfor ?>
						</select>
						<button type="submit" class="btn btn-success btn-block btn-sm mt-1">
							Asignar
						</button>
						<div class="alert my-1" id="msg-new-date" style="display: none;">
							<p class="m-0" id="text-msg"></p>
						</div>
					</form>
					<span id="msg-status" style="display: none;"><i class="fa fa-spin fa-spinner"></i>
						Asignando...</span>
				</fieldset>
			</td>
			<td class="align-top text-center">
				<form class="d-block" id="selectTeacher">
					<input type="hidden" id="idStudent" value="0">
					<input type="hidden" id="idClassHead" value="0">
					<div class="d-flex">
						<fieldset class="form-group d-flex m-0">
							<select class="custom-select" name="idTeacher" required id="list-professors"
								style="min-width: 19rem;">
							</select>
						</fieldset>
						<button type="submit" class="btn btn-success btn-sm">
							<i class="fa fa-check"></i>
						</button>
					</div>
					<div class="alert my-2" style="display: none;" id="msg-alert">
						<p class="m-0" id="text-alert">mensaje</p>
					</div>
				</form>
		</tr>
		<tr id="trStudentCloneLoader">
			<td colspan="5" class="text-center p-0">
				<h2 class="m-0 alert"><i class="fa fa-spin fa-spinner"></i>Cargando</h2>
			</td>
		</tr>
		<tr data-hour="6" id="trHourClone">
			<td id="hora">6 am</td>
			<td data-day="1">
			</td>
			<td data-day="2">
			</td>
			<td data-day="3">
			</td>
			<td data-day="4">
			</td>
			<td data-day="5">
			</td>
			<td data-day="6">
			</td>
		</tr>
	</table>
</div>
<script>
	var firstDayWeek = '<?php echo $week_start ?>';
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/js/admin/horarios.js?<?php echo time_unix(); ?>" type="text/javascript"></script>