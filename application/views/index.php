<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>EddyMusic Academy</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">

</head>

<body>
  <script>
    var base_url = '<?php echo base_url(); ?>';
    console.log("base url " + base_url);
  </script>
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
              <input id="username" name="user" type="text" class="form-control" placeholder="Usuario"
                required="required">
            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input id="contraseña1" name="pass" type="password" class="form-control" placeholder="Contraseña"
                required="required">
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
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> --> -->
  <script src="<?php echo base_url(); ?>assets/js/main.js?<?php echo strtotime(date('Y-m-d H:i:s')) ?>"></script>
  <script src="<?php echo base_url(); ?>assets/js/admin/login.js"></script>
</body>

</html>