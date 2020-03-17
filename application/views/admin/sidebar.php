<ul class=" list-group nav flex-column">
	<li class="nav-item shadow mt-1 mb-1 ml-2 mr-2 bg-white rounded text-center " id="nombreSucursal">
	</li>
	<li class="nav-item" onmouseover="change('botonAlumno')" onmouseout="unchange('botonAlumno')" id="botonAlumno">
		<a class="nav-link" data-active="addUser" href="<?php echo base_url() ?>admin/nav/addUser">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/alumno.svg">
			Alumnos
			<span class="sr-only">(current)</span>
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonCalendario')" onmouseout="unchange('botonCalendario')"
		id="botonCalendario">
		<a class="nav-link" data-active="calendario" href="<?php echo base_url() ?>admin/nav/default">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/torta.svg">
			Cumpleaños
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonBitacoras')" onmouseout="unchange('botonBitacoras')"
		id="botonBitacoras">
		<a class="nav-link" data-active="bitacoras" href="<?php echo base_url() ?>admin/nav/bitacoras">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/bitacora.svg">
			Bitacoras
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonProfesores')" onmouseout="unchange('botonProfesores')"
		id="botonProfesores">
		<a class="nav-link" data-active="profesores" href="<?php echo base_url() ?>admin/nav/profesores">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/profesor.svg">
			Profesores
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonHorarios')" onmouseout="unchange('botonHorarios')"
		id="botonHorarios">
		<a class="nav-link" data-active="horarios" href="<?php echo base_url() ?>admin/nav/horarios">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/horarios.svg">

			Horarios
		</a>
	</li>
	<li class="nav-item" onmouseover="change('reprogramaciones')" onmouseout="unchange('reprogramaciones')"
		id="reprogramaciones">
		<a class="nav-link" data-active="reprogramaciones" href="<?php echo base_url() ?>admin/nav/cancelaciones">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/reprogramacion.svg">

			Reprogramaciones
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonIngresos')" onmouseout="unchange('botonIngresos')"
		id="botonIngresos">
		<a class="nav-link" data-active="ingresos" href="<?php echo base_url() ?>admin/nav/ingresos">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/ingresos.svg">

			Ingresos
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonEgresos')" onmouseout="unchange('botonEgresos')" id="botonEgresos">
		<a class="nav-link" data-active="egresos" href="<?php echo base_url() ?>admin/nav/egresos">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/egresos.svg">

			Egresos
		</a>
	</li>
	<li class="nav-item" onmouseover="change('botonConfiguracion')" onmouseout="unchange('botonConfiguracion')"
		id="botonConfiguracion">
		<a class="nav-link" href="<?php echo base_url() ?>admin/nav/configuracion">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/instrumentos.svg">

			Instrumentos
		</a>
	</li>
	<li class="nav-item" onmouseover="change('directorio')" onmouseout="unchange('directorio')" id="directorio">
		<a class="nav-link " data-active="directorio" href="<?php echo base_url() ?>admin/nav/directorio">
			<img style="height: 45px;width: 45px;" src="<?php echo base_url() ?>assets/images/icons/directorio.svg">

			Directorio
			<span class="sr-only">(current)</span>
		</a>
	</li>
</ul>