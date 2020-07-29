<div class="container-fluid ">
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8 ml-2 mt-2 mr-2 shadow p-3 mb-5 bg-white rounded">
			<table class="table table-borderless table-hover table-responsive-sm " id="tableAccounts">
				<thead>
					<tr>
						<th>Usuario</th>
						<th>Sucursal</th>
						<th>Ultima Modificacion</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr id="trClone">
						<td id="user">Asistente Ibague</td>
						<td id="sucursal">Ibague</td>
						<td id="lastAccess">Hace 4 Horas</td>
						<td class="d-inline-flex">
							<button 
								type="button"
								id="changePassword"
								class="btn btn-outline-danger ml-4">
								<i class="fas fa-key"></i>
								Cambiar Contraseña
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src="<?php echo base_url() ?>assets/js/admin/adminAccounts.js?<?php echo time_unix(); ?>"></script>