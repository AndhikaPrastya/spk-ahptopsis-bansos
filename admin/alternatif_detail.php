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

  $page = "analisis";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";

  $id=$_GET['id'];
  $alternatif=query("SELECT * FROM alternatif where id='$id'")[0];
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Detail Alternatif</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
          
           
            <div class="row">
              <h2 class="section-title"></h2>
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card profile-widget">
                  <div class="profile-widget-description">
                    <h5>Data Warga</h5>
                    <table>
                      <tr>
                        <th>Nama</th>
                        <th> : </th>
                        <td><?=$alternatif ['nama']?></td>
                      </tr>
                      <tr>
                        <th>No.KK</th>
                        <th> : </th>
                        <td><?=$alternatif ['no_kk']?></td>
                      </tr>
                      <tr>
                        <th>Alamat</th>
                        <th> : </th>
                        <td><?=$alternatif ['alamat']?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            
              <h2 class="section-title"></h2>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card profile-widget">
                  <div class="profile-widget-description">
                    <h5>Keterangan</h5>

                    <div class="table-responsive">
                    <table class="table table-bordered" widtd="100%" cellspacing="0" id="tableData">
                      <thead class="table-info">
                      <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Nama Parameter</th>
                      </tr>
                      </thead>
                      <tr>
                      <?php $penilaian=query("SELECT b.nama, c.nama_parameter FROM nilai_analisis a JOIN kriteria b ON a.id_kriteria = b.id JOIN parameter c ON a.id_parameter = c.id_parameter WHERE a.id_alternatif = $id  ");
                        $i=1;
                        foreach ($penilaian as $key) : ?>
                        <td><?=$i; ?></td>
                        <td><?=$key['nama']; ?></td>
                        <td><?=$key['nama_parameter']; ?></td>
                      </tr>
                      <?php  $i++;
                     endforeach; ?>
                    </table>
                  </div>
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

