<?php
session_start();
if (isset($_SESSION["operator"])){
    header("location:operator/index.php");
    exit;
}
if (isset($_SESSION["admin"])){
    header("location:admin/index.php");
    exit;
}
if (isset($_SESSION["disable"])){
    header("location:../error.php");
    exit;
}

require 'config.php';
require 'functions.php';

if ( isset($_POST["login"])) {
  
  $username =$_POST["username"];
  $password =$_POST["password"];

  $result = mysqli_query($koneksi, "SELECT a.id ,a.nama, a.email, a.username, a.password, a.id_role, a.time_input, b.role FROM user a JOIN role_user b ON a.id_role = b.id WHERE BINARY username = '$username' AND id_status = 1");
  // cek username
  if( mysqli_num_rows($result) == 1 ) {

    // cek password
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"]) ) {
      if ($row['id_role']== 2) {
        $_SESSION["admin"] = true;
        $_SESSION["id"]=$row['id'];
        $_SESSION["nama"]=$row['nama'];
        $_SESSION["email"]=$row['email'];
        $_SESSION["username"]=$row['username'];
        $_SESSION["password"]=$row['password'];
        $_SESSION["time_input"]=$row['time_input'];
        $_SESSION["nama_role"]=$row['role'];
        header("Location: admin/index.php");
        exit;
      } elseif ($row['id_role']== 3)  {
        $_SESSION["operator"] = true;
        $_SESSION["id"]=$row['id'];
        $_SESSION["nama"]=$row['nama'];
        $_SESSION["email"]=$row['email'];
        $_SESSION["username"]=$row['username'];
        $_SESSION["password"]=$row['password'];
        $_SESSION["time_input"]=$row['time_input'];
        $_SESSION["nama_role"]=$row['role'];
        header("Location: operator/index.php");
        exit;
      } elseif ($row['id_role']== 1) {
        header("Location: error.php");
      } else {
        $error=true;
      }
    }
  }
  $error=true;
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
  <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="assets/img/logo.png" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Selamat Datang di <span class="font-weight-bold">SPK AHP TOPSIS BANSOS</span></h4>
            <p class="text-muted">Sistem Pendukung Keputusan Penerima Bantuan Sosial Menggunakan Metode <i>Analytical Hierarchy Process</i> (AHP) - <i>Technique for Others Reference by Similarity to Ideal</i> (TOPSIS) </p>
            <form method="POST" action="#" class="needs-validation" novalidate="">

              <?php 
              if(isset($error)):?>
                <div class="wrap-input100 validate-input m-b-10 alert alert-danger text-center" role="alert">
                  Incorrect Username or Password <p>Try Again!</p>
                </div>
              <?php endif?>

              <div class="form-group">
                <label for="username">Usernmae</label>
                <input id="username" type="username" class="form-control" name="username" id="username" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Please fill in your username
                </div>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" id="username" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>

              <div class="form-group text-right">
                
                <button type="submit" name="login" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>

              <div class="mt-5 text-center">
                Don't have an account? <a href="registrasi.php">Create new account</a>
              </div>
            </form>

            <div class="text-center mt-5 text-small">
              <span class="copyright">
                Copyright ©
                <script>
                  document.write(new Date().getFullYear())
                </script> prastya_andhika
              </span>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="assets/img/unsplash/login-bg.jpg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <img src="assets/img/logo.png" height="300px">
                <h1 class="mb-2 display-4 font-weight-bold">Pemerintah Desa Gebang</h1>
                <h5 class="font-weight-normal text-muted-transparent">Kecamatan Gebang, Kabupaten Cirebon</h5>
                <h7 class="font-weight-normal text-muted-transparent">Jl.Raya Pangeran Sutajaya No.67 Telp.662109 Desa Gebang Kec.Gebang Kab.Cirebon</h7>
              </div>
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
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
