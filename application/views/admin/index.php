<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Eddy music academy</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/plugins/dataTable/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/styles.css?<? echo time_unix(); ?>">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css?<? echo time_unix(); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	 
	
	<link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">
</head>
<body>
	<script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script>var active = '<?echo $view ?>';  var base_url = '<?echo base_url() ?>'; var level = <?php echo $level; ?></script>
	<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
		<!-- <span class="navbar-brand col-sm-3 col-md-2 mr-0 titleMenu">Academia Eddy Music</span> -->
		<span class="navbar-brand pl-2 pr-3 titleMenu">Academia Eddy Music</span>
		<!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Buscar" aria-label="Search"> -->
		<button class="navbar-toggler" id="toggleMenu" data-status="0">
			<span class="navbar-toggler-icon"></span>
		</button>
			<!--
			<ul class="navbar-nav px-3 menuHead">
				<?php if ($level==0): ?>
					<li class="nav-item text-nowrap" id="item-sucursal">
						<button id="btnHeadquaters" class="btn btn-menu">
							<i class="far fa-building"></i> Sucursales
						</button>
					</li>
				<?php endif ?>
				<li class="nav-item text-nowrap">
					<a href="<?php echo base_url() ?>login/logout" id="botonsalir">
						<button type="button" class="btn btn-menu">
							<i class="fas fa-sign-out-alt fa-lg"></i> Salir
						</button>
					</a>
				</li>
			</ul>-->
	</nav>
	<div class="container-fluid">
		<div class="row">
			<?php require __DIR__.'/sidebar.php'; ?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 px-sm-1">
				<?php require __DIR__.'/'.$view.'.php'; ?>
			</main>
		</div>
	</div>
	<div class="headquarters" id="content-headquarters">
		<video autoplay muted loop id="myVideo" class="video">
      <source src="<?php echo base_url() ?>assets/headquartes/guitarra.webm" type="video/mp4">
    </video>
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
				<!-- <img class="card-img-top" id="imag-head" src="<?php echo base_url() ?>assets/headquartes/armenia.jpg" alt="Card image cap" height="200"> -->
				<div class="card-body">
					<h5 class="card-title">
						<span id="title-card"></span>          
						<span class="active-headquarter" id="isActive">
						sucursal activa
						</span>
					</h5>
					<!-- <p class="card-text" id="text-card">Somos mas que solo musica</p> -->
					<button type="button" class="btn btn-dark" id="btn-change-headquarter">Iniciar</button>
				</div>
      		</div>
    	</div>
	</div>

	<footer>
		
		 <a href="https://www.andersonlaverde.com"> © Anderson Laverde - 2019 Copyright</a>
	</footer>
	<?php require __DIR__.'/modal.php'; ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-143760552-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-143760552-1');
	</script>

	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins/dataTable/datatables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins/jquery-number/jquery.number.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/admin/principal.js?<? echo time_unix(); ?>"></script>
	</body>
</html>