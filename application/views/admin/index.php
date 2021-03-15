<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eddy music academy 2021</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/styles.css?<?php echo time_unix(); ?>">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css?<?php echo time_unix(); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<!-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css"rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/simple-sidebar.css?<?php echo time_unix(); ?>">
	<link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">
</head>

<body>
	<script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script>
		var active = '<?php echo $view ?>';
		var base_url = '<?php echo base_url() ?>';
		var level = '<?php echo $level; ?>' ;
	</script>
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div class="bg-light border-right" id="sidebar-wrapper">
			<div class="list-group list-group-flush">
				<?php require __DIR__.'/sidebar.php'; ?>
			</div>
		</div>

		<!-- Page Content -->
		<div id="page-content-wrapper">

			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom ">
				<i class="fas fa-bars fa-2x" id="menu-toggle"></i>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
						<li class="nav-item" id="nombreUsuario"></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Acciones
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<!-- If the user is 'admin' or 'contador' role, the profile can change between sucursales  -->
								<?php if ($level==0 || $level==5): ?>
								<a id="btnHeadquaters" class="dropdown-item">
									<img style="height: 45px;width: 45px;"
										src="<?php echo base_url() ?>assets/images/icons/sucursal.svg">
									Cambiar Susursal
								</a>
								<?php endif ?>
								<?php if ($level==0): ?>
									<a class="dropdown-item" data-active="addUser"
										href="<?php echo base_url() ?>admin/nav/adminAccounts"
									>
										<img style="height: 45px;width: 45px;"
											src="<?php echo base_url() ?>assets/images/icons/cuentas.svg"
										>
											Cuentas
									</a>
								<?php endif ?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo base_url() ?>login/logout">
									Cerrar Sesion
									<img style="height: 45px;width: 45px;"
										src="<?php echo base_url() ?>assets/images/icons/exit.svg">
								</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<!-- Main container with the views -->
			<div class="container-fluid" style="overflow-y: scroll;" >
				<?php require __DIR__.'/'.$view.'.php'; ?>
			</div>
		</div>
	</div>

	<!-- Sucursal change screen -->
	<div class="headquarters" id="content-headquarters">
		<button type="button" class="btn-close-list-headers" id="btn-close-headquarters">
			<i class="fas fa-times"></i>
		</button>
		<div class="container content-row-headquarters">
			<div class="row" id="content-list-headquartes">
			</div>
		</div>
	</div>
	<div class="d-none">
		<div class="col" id="card-headquarter">
			<div class="card w-100" style="max-width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">
						<span id="title-card"></span>
						<span class="active-headquarter" id="isActive">
							Sucursal activa
						</span>
					</h5>
					<button type="button" class="btn btn-dark" id="btn-change-headquarter">Iniciar</button>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<a style="color:white;" href="https://slinqer.com"> © 2021 By Slinqer S.A.S.
		</a>
	</footer>
	<?php require __DIR__.'/modal.php'; ?>
	<script>
		$("#menu-toggle").click(function (e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
	<script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
	<!-- TODO // DONT UNCOMMENT THIS LINE UNTIL REMOVE BOOSTRAP TO AVOID CSS PROBLEMS WITH IONIC -->
	<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css"/> -->
	<script src="<?php echo base_url() ?>assets/js/plugins/jquery-number/jquery.number.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/admin/principal.js?<?php echo time_unix(); ?>"></script>
</body>

</html>