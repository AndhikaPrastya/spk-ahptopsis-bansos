<?php 
session_start();
if (isset($_SESSION["operator"])){
  header("location:../operator/index.php");
  exit;
}
if (isset($_SESSION["disable"])){
  header("location:../error.php");
  exit;
}
if (!isset($_SESSION["admin"])){
  header("location:../index.php");
  exit;
}

  $page = "index";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
?>

<!-- Begin Main Content -->
<div class="main-content ">
  <section class="section ">
      <div class="section-header">
        <h1>Dashboard</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
      <h5 class="section-title"> Selamat Datang <?=$_SESSION['nama']?> </h5>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <a href="user.php">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                     <?php $user = query("SELECT * FROM user WHERE id_status = 1");
                        $jml_user = count($user); ?>
                    <h4>Total User</h4>
                  </div>
                  <div class="card-body">
                    <?=$jml_user?>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <a href="kriteria.php">
                <div class="card-icon bg-danger">
                  <i class="far fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                     <?php $kriteria = query("SELECT * FROM kriteria");
                        $jml_kriteria = count($kriteria); ?>
                    <h4>Total Kriteria</h4>
                  </div>
                  <div class="card-body">
                       <?=$jml_kriteria?>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <a href="parameter_kriteria.php">
                <div class="card-icon bg-warning">
                  <i class="fas fa-chart-pie"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <?php $parameter = query("SELECT * FROM parameter");
                        $jml_parameter = count($parameter); ?>
                    <h4>Total Parameter Kriteria</h4>
                  </div>
                  <div class="card-body">
                   <?=$jml_parameter?>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <a href="alternatif.php">
                <div class="card-icon bg-info">
                  <i class="fas fa-table"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <?php $alternatif = query("SELECT * FROM alternatif");
                        $jml_alternatif = count($alternatif); ?>
                    <h4>Total Alternatif</h4>
                  </div>
                  <div class="card-body">
                    <?=$jml_alternatif?>
                  </div>
                </div>
                </a>
              </div>
            </div>
             <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <a href="laporan.php">
                <div class="card-icon bg-success">
                  <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <?php $laporan = query("SELECT * FROM laporan");
                        $jml_laporan = count($laporan); ?>
                    <h4>Total Laporan Seleksi</h4>
                  </div>
                  <div class="card-body">
                   <?=$jml_laporan?>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php 
  include('../templetes/footer-admin.php');
?>


