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

  $page = "rangking";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataLaporan($_POST)>0){
     echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data berhasil dihapus!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('laporan.php');
       },1500);
       </script>
       ";
      }else{
      echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data berhasil dihapus!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('laporan.php');
       },1500);
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataLaporan($_POST)>0){
    echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data berhasil diubah!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('laporan.php');
       },1500);
       </script>
       ";
      }else{
         echo"
          <script type='text/javascript'>
          setTimeout(function(){
             swal({
              title: 'Data gagal diubah!',
              icon: 'error',
              timer: 3200,
              showConfirmButton: true
              });
         },10);
         window.setTimeout(function(){
         window.location.replace('laporan.php');
         },1500);
         </script>
         ";
      }
}
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
                              <td class="text-left"><?=$row['nama']?></td>
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

                                  <!-- <a href="rangking.php?id_laporan=<?=$row['id_laporan'] ?>" class="btn btn-info btn-sm" ><i class="far fa-eye"></i> Preview</a>
 -->
                                  <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_laporan']; ?>"> 
                                    <i class="fas fa-edit"></i> Edit</button>

                                  <input type="hidden" name="id_laporan" value="<?=$row['id_laporan'];?>">
                                  <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nama'] ?>?');">
                                      <i class="fas fa-trash-alt"></i> Delete</button>
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

<?php include('../templetes/footer-admin.php'); ?>

          <!-- Modal Edit Data -->
              <?php foreach ($laporan as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id_laporan'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning text-white" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Laporan</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <input type="hidden" name="id_laporan" class="form-control" 
                                                                   value="<?=$row['id_laporan'] ?>">

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama laporan :</label>
                              <input type="text" class="form-control mt-1" name="nama" value="<?=$row['nama'] ?>" required>
                            </div>

                            <div class="form-group">
                              <label for="kuota" class="col-form-label">Kuota Penerima BANSOS :</label>
                              <input type="number" class="form-control mt-1" name="kuota" min="1" value="<?=$row['kuota'] ?>" required>
                            </div>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" name="edit" class="btn btn-primary">Update</button>
                         </div>
                       </form>
                     </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
