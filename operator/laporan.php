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

  $page = "rangking";
  include('../templetes/topbar-operator.php');
  include('../templetes/menubar-operator.php');
  require_once "../functions.php";
  require_once "../config.php";

?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Laporan Seleksi</h1>
      </div>

      <!-- Begin form content -->
      <div class="section-body">
           <div class="card">
              <div class="card-body">
               
                <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableData">
                         <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle">No</th>
                            <th class="text-center table-white align-middle">Nama Laporan</th>
                            <th class="text-center table-white align-middle">Tanggal</th>
                            <th class="text-center table-white align-middle">Waktu</th>
                            <th class="text-center table-white align-middle">Kuota Penerima</th>
                            <th class="text-center table-white align-middle">Aksi</th>
                          </tr>
                        </thead>
                         <?php  
                                 $i=1;
                                 $laporan=mysqli_query($koneksi,"SELECT * FROM laporan ORDER BY id_laporan DESC");
                                 while($row = mysqli_fetch_array($laporan)): ?>
                            <tr>
                              <td class="text-center"><?=$i;?></td>
                              <td class="text-center"><?=$row['nama']?></td>
                              <td class="text-center"><?= date('d M Y', strtotime($row['time_input']));?></td>
                              <td class="text-center"><?= date('H:i:s', strtotime($row['time_input']));?></td>
                              <td class="text-center"><?=$row['kuota']?></td>
                              <td class="text-center">
                                <form method="POST">
                                   <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-eye"></i> Preview
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="rank_rekomendasi.php?id_laporan=<?=$row['id_laporan'] ?>">
                                                             Data Rekomendasi</a>
                                    <a class="dropdown-item" href="rank_unrekomendasi.php?id_laporan=<?=$row['id_laporan'] ?>">
                                                             Data Tidak Direkomendasi</a>
                                    <a class="dropdown-item" href="rank_all.php?id_laporan=<?=$row['id_laporan'] ?>">Data Semua Alternatif</a>
                                  </div>
                                  
                                </form>     
                              </td>
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


