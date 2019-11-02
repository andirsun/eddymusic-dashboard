<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Eddy music academy 2019</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
	

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/styles.css?<? echo time_unix(); ?>">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css?<? echo time_unix(); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/carousel/dist/assets/owl.carousel.min.css?<? echo time_unix(); ?>">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/simple-sidebar.css?<? echo time_unix(); ?>">
	<link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">
</head>
<body>
	<script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script>var active = '<?echo $view ?>';  var base_url = '<?echo base_url() ?>'; var level = <?php echo $level; ?></script>
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div class="bg-light border-right" id="sidebar-wrapper">
			<div class="list-group list-group-flush">
				<?php require __DIR__.'/sidebar.php'; ?>
			</div>
		</div>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div id="page-content-wrapper">

			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom ">
				<i class="fas fa-bars fa-2x" id="menu-toggle"></i>
				
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
					<li class="nav-item" id="nombreUsuario">
						<svg version="1.1" style="height: 40px;width: 40px;" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.003 512.003" xml:space="preserve"> <polygon style="fill:#E6AF78;" points="335.446,361.939 335.446,300.15 176.558,300.15 176.558,361.939 256.002,432.556 "></polygon> <path style="fill:#EFF2FA;" d="M458.286,390.843l-109.229-25.701c-1.65-0.388-3.167-1.047-4.587-1.846l-88.469,51.607L170.982,360.8 c-2.201,2.072-4.933,3.612-8.036,4.343L53.717,390.844c-15.95,3.753-27.222,17.985-27.222,34.37v69.134 c0,9.751,7.904,17.654,17.654,17.654h423.702c9.751,0,17.654-7.904,17.654-17.654v-69.134 C485.507,408.828,474.235,394.595,458.286,390.843z"></path> <path style="fill:#D29B6E;" d="M176.558,300.15v65.193c100.078,36.057,158.888-54.185,158.888-54.185v-11.009H176.558V300.15z"></path> <path style="fill:#F0C087;" d="M141.249,97.127l7.692,169.228c0.718,15.809,8.47,30.47,21.13,39.965l36.498,27.374 c9.168,6.875,20.318,10.593,31.778,10.593h35.309c11.46,0,22.61-3.717,31.778-10.593l36.498-27.374 c12.66-9.496,20.412-24.155,21.13-39.965l7.692-169.228C370.753,97.127,141.249,97.127,141.249,97.127z"></path> <path style="fill:#E6AF78;" d="M229.521,132.435c35.309,0,88.271-8.827,100.833-35.309H141.249l7.692,169.228 c0.718,15.809,8.47,30.469,21.131,39.965l36.498,27.374c9.168,6.875,20.318,10.593,31.778,10.593h17.654 c-17.654,0-52.963-35.309-52.963-79.444c0-21.586,0-79.444,0-105.926C203.039,150.089,211.866,132.435,229.521,132.435z"></path> <g> <path style="fill:#E4EAF6;" d="M91.3,454.714l-57.199-51.382c-4.793,6.069-7.603,13.706-7.603,21.882v69.134 c0,9.751,7.904,17.654,17.654,17.654h61.79v-24.454C105.941,475.021,100.618,463.084,91.3,454.714z"></path> <path style="fill:#E4EAF6;" d="M420.705,454.714l57.199-51.382c4.793,6.069,7.603,13.706,7.603,21.882v69.134 c0,9.751-7.904,17.654-17.654,17.654h-61.79v-24.454C406.063,475.021,411.386,463.084,420.705,454.714z"></path> </g> <polygon style="fill:#5B5D6E;" points="278.07,512.001 233.934,512.001 239.451,432.556 272.553,432.556 "></polygon> <path style="fill:#515262;" d="M278.07,414.902h-44.136v16.613c0,5.451,4.418,9.869,9.869,9.869H268.2 c5.451,0,9.869-4.418,9.869-9.869v-16.613H278.07z"></path> <g> <path style="fill:#E4EAF6;" d="M175.319,342.287l80.684,72.615c0,0-22.596,11.407-50.48,34.398 c-5.752,4.742-14.453,2.821-17.538-3.966l-37.907-83.394l11.992-17.987C165.054,339.473,171.318,338.687,175.319,342.287z"></path> <path style="fill:#E4EAF6;" d="M336.686,342.287l-80.684,72.615c0,0,22.596,11.407,50.48,34.398 c5.752,4.742,14.453,2.821,17.538-3.966l37.907-83.394l-11.992-17.987C346.95,339.473,340.686,338.687,336.686,342.287z"></path> </g> <path style="fill:#785550;" d="M309.516,38.647l8.275,58.48c37.775,7.555,43.219,66.837,44.003,83.769 c0.142,3.073,1.123,6.04,2.79,8.625l14.413,22.358c0,0-4.933-36.964,17.654-61.79C396.652,150.089,404.408,3.338,309.516,38.647z"></path> <path style="fill:#F0C087;" d="M387.851,208.115l-9.965,39.861c-1.181,4.725-5.425,8.038-10.296,8.038l0,0 c-5.353,0-9.867-3.985-10.531-9.296l-5.097-40.77c-1.364-10.913,7.144-20.551,18.142-20.551h0.008 C382.008,185.398,390.736,196.575,387.851,208.115z"></path> <path style="fill:#694B4B;" d="M149.709,22.831l13.056,8.919c-59.031,43.584-47.998,118.339-47.998,118.339 c17.654,17.654,17.654,61.79,17.654,61.79l17.654-17.654c0,0-6.813-50.998,26.481-70.617c30.895-18.206,57.928-8.827,85.513-8.827 c73.927,0,94.616-27.861,91.03-61.79c-1.856-17.556-28.698-54.126-97.098-52.963C228.397,0.497,176.558,8.855,149.709,22.831z"></path> <path style="fill:#5A4146;" d="M144.559,107.057c0,0-9.379-36.964,18.206-75.306c-59.031,43.584-47.998,118.339-47.998,118.339 c17.654,17.654,17.654,61.79,17.654,61.79l17.654-17.654c0,0-6.813-50.998,26.481-70.617c30.895-18.206,57.928-8.827,85.513-8.827 c12.023,0,22.5-0.805,31.832-2.185C236.969,114.505,203.408,71.38,144.559,107.057z"></path> <path style="fill:#E6AF78;" d="M124.153,208.115l9.965,39.861c1.181,4.725,5.425,8.038,10.296,8.038l0,0 c5.353,0,9.867-3.985,10.531-9.296l5.097-40.77c1.364-10.913-7.144-20.551-18.142-20.551h-0.008 C129.996,185.398,121.268,196.575,124.153,208.115z"></path> <path style="fill:#E4EAF6;" d="M370.755,494.346h-61.79c-4.875,0-8.827,3.952-8.827,8.827v8.827h79.444v-8.827 C379.582,498.299,375.629,494.346,370.755,494.346z"></path> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
							
					</li>
					<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Acciones
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url() ?>login/logout">
							<svg style="height: 50px;width: 50px;"  viewBox="-53 0 511 512"  xmlns="http://www.w3.org/2000/svg"><path d="m7.480469 154h390v150h-388.125" fill="#fe3934"/><path d="m7.480469 154h45v150h-44.78125" fill="#dd2323"/><path d="m404.980469 311.5v-165h-389.480469v-15h6.980469v-15h-6.980469v-116.5h-15v512h15v-170.5h6.980469v-15h-6.980469v-15zm-15-150v135h-374.480469v-135zm0 0"/><g fill="#fff"><path d="m44.980469 266.5h37.5v-15h-22.5v-15h15v-15h-15v-15h22.5v-15h-37.5zm0 0"/><path d="m127.480469 212.230469-10.363281-20.730469h-19.636719v15h10.367187l11.25 22.5-11.25 22.5h-10.367187v15h19.636719l10.363281-20.730469 10.367187 20.730469h19.632813v-15h-10.363281l-11.25-22.5 11.25-22.5h10.363281v-15h-19.632813zm0 0"/><path d="m172.480469 191.5h15v75h-15zm0 0"/><path d="m202.480469 206.5h15v60h15v-60h15v-15h-45zm0 0"/><path d="m319.480469 200.5-9 12 12 9h-60v15h60l-12 9 9 12 38-28.5zm0 0"/></g></svg>
							Cerrar Sesion
						</a>
					</div>
					</li>
				</ul>
				</div>
			</nav>
			<div class="container-fluid">
				<?php require __DIR__.'/'.$view.'.php'; ?>
			</div>
		</div>
		<!-- /#page-content-wrapper -->
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
		
		 <a style="color:white;"href="https://www.andersonlaverde.com"> © 2019 Copyright - Made By Anderson Laverde  
		 </a>
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
	<script>
	
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins/jquery-number/jquery.number.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/admin/principal.js?<? echo time_unix(); ?>"></script>
	</body>
</html>