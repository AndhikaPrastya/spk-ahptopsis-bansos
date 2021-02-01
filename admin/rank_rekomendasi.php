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
  date_default_timezone_set('Asia/Jakarta');
  $page = "rangking";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
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
        <h1>Rangking Penilaian Data Rekomendasi</h1>
      </div>
      <h2 class="section-title"><b>Laporan </b>: <?=$laporan['nama'];?> <b>[</b> <?= date('d M Y H:i:s', strtotime($laporan['time_input']));?> <b>]</b></h2>
      <h2 class="section-title"><b>Jumlah Semua KK </b>: <?=$jml_alt?> KK </h2> 
      <h2 class="section-title"><b>Jumlah Penerima BANSOS </b>:  <?=$laporan['kuota']?> KK </h2> 
     
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                <a class="btn btn-success float-right" href="../cetak_rekom.php?id_laporan=<?=$id_laporan?>" 
                    target="_blank" role="button">
                    <i class="fas fa-print"></i> Cetak</a>
              </div>
              <div class="card-body">
               
                <div class="table-responsive">
                      <table class="table table-bordered" widtd="100%" cellspacing="0" id="tableData">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle">Rangking</th>
                            <th class="text-center table-white align-middle">No.KK</th>
                            <th class="text-center table-white align-middle">Nama</th>
                            <th class="text-center table-white align-middle">Alamat</th>
                            <th class="text-center table-white align-middle">Jumlah Keluarga</th>
                            <th class="text-center table-white align-middle">KK Terdaftar</th>
                            <th class="text-center table-white align-middle">Nilai</th>
                            <th class="text-center table-white align-middle">Keterangan</th>
                          </tr>
                        </thead>
                         <?php  
                                 $i=1;
                                 $rangking=mysqli_query($koneksi,"SELECT a.nilai, a.rank, b.nama, b.no_kk, b.alamat, 
                                              b.time_input, b.jml_keluarga, b.kk_terdaftar, c.kuota FROM rangking a JOIN alternatif b 
                                              ON a.id_alternatif = b.id JOIN laporan c ON a.id_laporan = c.id_laporan 
                                              WHERE a.id_laporan = $id_laporan AND a.rank <= c.kuota ");
                                 while($key9 = mysqli_fetch_array($rangking)): ?>
                            <tr>
                              <td class="text-center"><?=$i;?></td>
                              <td class="text-center"><?=$key9['no_kk']?></td>
                              <td class="text-center"><?=$key9['nama']?></td>
                              <td class="text-center"><?=$key9['alamat']?></td>
                              <td class="text-center"><?=$key9['jml_keluarga']?></td>
                              <td class="text-center"><?= date('d M Y',$key9['kk_terdaftar']);?></td>
                              <td class="text-center"><?=$key9['nilai']?></td>
                              <td class="text-center">Rekomendasi</td>
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

<?php include('../templetes/footer-admin.php'); ?>
