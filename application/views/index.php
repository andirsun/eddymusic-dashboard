<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>EddyMusic Academy</title>
  <!-- Bootstrap -->
  <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet"> <!-- la base url es la pagina y el resto es la ruta donde se encuentra-->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">

</head>

<body>
  <script>var base_url = '<?echo base_url(); ?>'</script>
  <div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Ingresar</h3>
			</div>
			<div class="card-body">
				<form id="formLogin">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						  <input id="username" name="user" type="text" class="form-control" placeholder="Correo" required="required">
            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input id="contraseña1" name="pass" type="password" class="form-control" placeholder="Constraseña" required="required">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-block ml-auto login_btn">Iniciar</button>
            </div>
            <div class="alert alert-danger py-2" style="display: none;" id="msg-login">
            	<h4 class="m-0 text-center" id="txt-login-msg"></h4>
            </div>
				</form>
			</div>
		</div>
	</div>
</div>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/main.js?<?php echo strtotime(date('Y-m-d H:i:s')) ?>"></script>
  <script src="<?php echo base_url() ?>assets/js/admin/login.js?<? echo time_unix(); ?>"></script>
</body>

</html>
