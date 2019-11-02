<ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
			aria-controls="pills-home" aria-selected="true">Estudiantes</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
			aria-controls="pills-profile" aria-selected="false">Profesores</a>
	</li>
	
</ul>
<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
		<div class="shadow p-3 mb-5 bg-white rounded" id='calendar'></div>
	</div>
	<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
		<div class="shadow p-3 mb-5 bg-white rounded" id='calendar2'></div>	
	</div>
</div>
<link href='<?php echo base_url() ?>assets/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url() ?>assets/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<style>
	body {
		margin: 40px 30px;
		padding: 0;
		font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
		font-size: 16px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	#calendar2 {
		max-width: 900px;
		margin: 0 auto;
	}
</style>
</head>

<script src='<?php echo base_url() ?>assets/fullcalendar/packages/core/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/fullcalendar/packages/interaction/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/fullcalendar/packages/daygrid/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/js/admin/calendario.js?<? echo time_unix(); ?>'></script>