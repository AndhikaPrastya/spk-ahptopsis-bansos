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

  $kriteria = query("SELECT * FROM kriteria ORDER BY id");

  $jml_kriteria = count($kriteria);

?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Alternatif</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body"> 
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-footer bg-whitesmoke">
      
                    <a class="btn btn-success float-right " href="output_topsis.php" role="button">Lanjut <i class="fas fa-angle-double-right"></i></a>
              
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableData">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle" colspan="2">ALTERNATIF</th>
                            <th class="text-center" colspan="<?php echo $jml_kriteria; ?>">KRITERIA</th>
                            <th class="text-center table-white align-middle" rowspan="2">Aksi</th>
                          </tr>
                          <tr>
                            <th class="text-center">No.KK</th>
                            <th class="text-center">Nama</th>
                              <?php foreach ($kriteria as $key1) : ?>
                            <th class="text-center"><?=$key1['kode_kriteria']; ?></th>
                              <?php endforeach; ?>
                          </tr>
                          </thead>
                              <?php $alternatif = query("SELECT * FROM alternatif WHERE id_status=1 ORDER BY id DESC"); ?>
                              <?php foreach ($alternatif as $key2) : ?>
                          <tr>
                            <th class="table-grey text-center"><?=$key2['no_kk']; ?></th>
                            <th class="table-grey"><a class="text-dark2" 
                                href="alternatif_detail.php?id=<?=$key2['id'] ?>">
                                <?=$key2['nama']; ?></a></th>

                              <?php
                                  $id=$key2['id'];
                                  $analisis = query(" SELECT b.id_alternatif,a.nilai_parameter
                                  FROM parameter a JOIN nilai_analisis b USING(id_parameter)
                                  WHERE  b.id_alternatif=$id"); 
                                  foreach ($analisis as $key3) : 
                              ?>

                            <td class="text-center"><?=$key3['nilai_parameter']; ?></td>

                              <?php 
                                  $hasil[][]=$key3['nilai_parameter'];
                                  endforeach; 
                              ?>

                            <td class="text-center">
                                <form method="POST">
                                  <a href="penilaian_alternatif.php?id=<?=$key2['id'] ?>" class="btn btn-info btn-sm" ><i class="far fa-calendar-check"></i> penilaian</a>
                                </form>     
                            </td>
                          </tr>
                              <?php endforeach; ?>
                      </table>
                    </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php'); ?>