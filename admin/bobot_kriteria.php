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

  $page = "kriteria";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Perbandingan Kriteria</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="kriteria.php">Kriteria</a></div>
              <div class="breadcrumb-item">Perbandingan Kriteria</div>
            </div>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
            
        <div class="card">
              <div class="card-body">
                 <?php showTabelPerbandingan('kriteria','kriteria'); ?>
              </div>
        </div>.

      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php 
  include('../templetes/footer-admin.php');
?>
