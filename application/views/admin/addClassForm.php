<link href="<?php echo base_url() ?>assets/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" type="text/css" >
<form formAddHeadClass class="mb-4">
	<input type="hidden" id="instrumentId" value="0">
	<div class="row">
		<div class="col-sm-3 d-inline-flex align-items-end">	
			<fieldset class="form-group w-100 m-0">
				<label for="list-instrument-select">Instrumento</label>
				<select id="list-instrument-select" class="form-control"></select>
			</fieldset>
		</div>
		<div class="col-sm-3 d-inline-flex align-items-end">
			<fieldset class="form-group m-0">
				<label for="dateI">Fecha</label>
	         <div class="input-group date" id="dateformAddHeadClass" data-target-input="nearest">
               <input type="text" class="form-control datetimepicker-input" data-target="#dateformAddHeadClass"/>
              	<div class="input-group-append" data-target="#dateformAddHeadClass" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              	</div>
            </div>
			</fieldset>
		</div>
		<div class="col-ms-3 d-inline-flex align-items-end">
			<fieldset class="form-group m-0">
				<label for="HorasI">Horas</label>
		    	<div class="input-group date" id="HorasformAddHeadClass" data-target-input="nearest">
               <input type="text" class="form-control datetimepicker-input" data-target="#HorasformAddHeadClass"/>
              	<div class="input-group-append" data-target="#HorasformAddHeadClass" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              	</div>
            </div>
			</fieldset>
		</div>
		<div class="col-sm-3 d-inline-flex align-items-end">
			<button type="submit" class="btn btn-block btn-success">
				Crear
			</button>
		</div>
	</div>
</form>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/tempusdominus-bootstrap-4.min.js"></script>
<script>
	function datetime() {
		$('[id=dateformAddHeadClass]').datetimepicker({
			format: 'L'
		});
		$('[id=HorasformAddHeadClass]').datetimepicker({
	     	format: 'LT'
	 	});
	}
</script>