<?php 
session_start();
if (!isset($_SESSION["operator"])){
  header("location:../index.php");
  exit;
}
if (isset($_SESSION["disable"])){
  header("location:../error.php");
  exit;
}
if (isset($_SESSION["admin"])){
  header("location:../admin/index.php");
  exit;
}
    date_default_timezone_set('Asia/Jakarta');
    $page = "rangking";
    include('../templetes/topbar-operator.php');
    include('../templetes/menubar-operator.php');
    require_once "../functions.php";
    require_once "../config.php";

  $id_laporan=$_GET['id_laporan'];
  $rangking=query("SELECT * FROM rangking where id_laporan='$id_laporan'")[0];

  $alt=mysqli_query($koneksi, "SELECT * FROM rangking where id_laporan='$id_laporan'");
  $jml_alt=mysqli_num_rows($alt);

  $laporan=query("SELECT * FROM laporan WHERE id_laporan='$id_laporan'")[0];
  $jml_unrekom=$jml_alt-$laporan['kuota'];
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Rangking Penilaian Data Yang Tidak Direkomendasi</h1>
      </div>
      <h2 class="section-title"><b>Laporan </b>: <?=$laporan['nama'];?> <b>[</b> <?= date('d M Y H:i:s', strtotime($laporan['time_input']));?> <b>]</b></h2>
      <h2 class="section-title"><b>Jumlah Semua KK </b>: <?=$jml_alt?> KK </h2> 
      <h2 class="section-title"><b>Jumlah Yang Tidak Menerima BANSOS </b>:  <?=$jml_unrekom?> KK </h2> 
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                <a class="btn btn-success float-right" href="../cetak_unrekom.php?id_laporan=<?=$id_laporan?>" target="_blank" role="button">
                    <i class="fas fa-print"></i> Cetak</a>
              </div>
              <div class="card-body">
               

                <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableData">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle">Rangking</th>
                            <th class="text-center table-white align-middle">No.KK</th>
                            <th class="text-center table-white align-middle">Nama</th>
                            <th class="text-center table-white align-middle">Nilai</th>
                            <th class="text-center table-white align-middle">Keterangan</th>
                          </tr>
                        </thead>
                         <?php  
                                $i=1;
                                $rangking=mysqli_query($koneksi,"SELECT a.nilai, b.nama, b.no_kk, b.alamat, 
                                              b.time_input, b.jml_keluarga, b.kk_terdaftar, c.kuota FROM rangking a JOIN alternatif b 
                                              ON a.id_alternatif = b.id JOIN laporan c ON a.id_laporan = c.id_laporan 
                                              WHERE a.id_laporan = $id_laporan AND a.rank > c.kuota");
                                while($key9 = mysqli_fetch_array($rangking)): ?>
                            <tr>
                              <td class="text-center"><?=$i;?></td>
                              <th class="text-center"><?=$key9['no_kk']?></th>
                              <th class="text-center"><?=$key9['nama']?></th>
                              <td class="text-center"><?=$key9['nilai']?></td>
                              <td class="text-center">Tidak Direkomendasi</td>
                            </tr>
                            <?php $i=$i+1;
                              endwhile; ?>       
                      </table>
                    </div>
              </div>
            </div>
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-operator.php'); ?>