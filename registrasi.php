<?php 
date_default_timezone_set('Asia/Jakarta');
require 'config.php';
require 'functions.php';

if (isset($_POST["register"])) {
  
  if (register($_POST)>0) {
   echo "<script>
        alert('Selamat data sudah terdaftar dan tunggu verifikasi oleh Administrator');
        document.location.href='index.php';
        </script>";
  } else {
    echo mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login AHP-TOPSIS BANSOS</title>

  <!-- General CSS Files -->
  <link rel="icon" type="image/png" href="assets/img/logo.png"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="node_modules/selectric/public/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

 <style type="text/css">
      .latar-belakang {
        background-image: url('assets/img/unsplash/login-bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
      }
      .text-judul {
        color: #ffffff;
      }
    </style>

<body>
  <div id="app" class="latar-belakang">
    <section class="section">
      <div class="container mt-5" >
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/logo.png" alt="logo" width="100" class="shadow-light rounded-circle">
              <h5>SPK AHP-TOPSIS BANSOS</h5>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Registrasi Akun</h4></div>

              <div class="card-body">
                <form method="POST">

                  <div class="form-group">
                    <label for="nama">Full Name</label>
                    <input id="nama" type="nama" class="form-control" name="nama" required>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="username" class="form-control" name="username" required>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" name="password2" class="form-control" required>
                    </div>
                  </div>
                  <input class="input100" type="hidden" name="id_role" id="id_role" value="1">
                  <input class="input100" type="hidden" name="time_input" id="time_input" 
                                                        value="<?=date("Y-m-d H:i:s"); ?>">
                  <input class="input100" type="hidden" name="id_status" id="id_status" value="1">

                  <div class="form-group">
                    <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer text-judul">
              <span class="copyright">
                Copyright ©
                <script>
                  document.write(new Date().getFullYear())
                </script> prastya_andhika
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="node_modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="node_modules/selectric/public/jquery.selectric.min.js"></script>
  <!-- sweetalert -->
  <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/auth-register.js"></script>
   <!-- sweetalrt -->
  <script src="assets/js/page/modules-sweetalert.js"></script>
  <script src="assets/js/my-sweetalert.js"></script>

</body>
</html>
