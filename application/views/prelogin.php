<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/prelogin.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css">
    <link rel="icon" href="<?php echo base_url()?>assets/images/miniicono.png">
    <title>Academia Eddy Music</title>

  </head>
  <body >
    <audio autoplay src="<?php echo base_url()?>assets/music/intro.mp3"></audio>
    <video autoplay muted loop id="myVideo">
      <source src="<?php echo base_url()?>assets/videos/guitarra.webm" type="video/mp4">
    </video>
    <div class="container">
      <div class="row justify-content-center align-items-center minh-100">
        <!--<div class="col">
          <video id="video"src="./assets/video2.mp4" muted autoplay loop ></video>
        </div>
        background="./assets/fondo.jpg"
      -->
        <div class="col">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo base_url() ?>assets/images/ibague.jpg" alt="Card image cap" height="200">
            <div class="card-body">
              <h5 class="card-title">♪ Sede Ibague ♪</h5>
              <p class="card-text">♫ Somos mas que solo musica ♫</p>
              <a href="<?php echo base_url() ?>login/login" class="btn btn-warning">Iniciar ♫</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo base_url() ?>assets/images/armenia.jpg" alt="Card image cap" height="200">
            <div class="card-body">
              <h5 class="card-title">♪ Sede Armenia ♪</h5>
              <p class="card-text">♫ Somos mas que solo musica ♫</p>
              <a href="<?php echo base_url() ?>login/login" class="btn btn-warning">Iniciar ♫</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo base_url() ?>assets/images/pitalito.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">♪ Sede Pitalito ♪</h5>
              <p class="card-text">♫ Somos mas que solo musica ♫</p>
              <a href="<?php echo base_url() ?>login/login" class="btn btn-warning">Iniciar ♫</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>


</html>