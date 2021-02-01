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
  require_once "../config.php";

if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataKriteria($_POST)>0){
    echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data berhasil ditambahkan!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('kriteria.php');
       },1500);
       </script>
       ";
      }else{
        echo"
          <script type='text/javascript'>
          setTimeout(function(){
             swal({
              title: 'Data gagal ditambahkan!',
              icon: 'error',
              timer: 3200,
              showConfirmButton: true
              });
         },10);
         window.setTimeout(function(){
         window.location.replace('kriteria.php');
         },1500);
         </script>
         ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataKriteria($_POST)>0){
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
       window.location.replace('kriteria.php');
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
       window.location.replace('kriteria.php');
       },1500);
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataKriteria($_POST)>0){
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
       window.location.replace('kriteria.php');
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
         window.location.replace('kriteria.php');
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
        <h1>Kriteria</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body"> 
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-footer bg-whitesmoke">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i>
                      Tambah Kriteria
                    </button>
      
                    <a class="btn-sm btn-success float-right" href="bobot_kriteria.php" role="button">Lanjut</a>
              
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tableData">
                        <thead class="table-info">
                           <tr>
                              <th class="text-center">No</th>
                              <th class="text-center">Nama_pasien</th>
                              <th class="text-center">alamat</th>
                              <th class="text-center">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>  

                             <?php  
                                 $i=1;
                                 $pasien=mysqli_query($koneksi,"SELECT * FROM pasien ORDER BY id");
                                 while($row = mysqli_fetch_array($pasien)): ?>

                                    <tr>
                                      <td class="text-center"><?=$i;?></td>
                                      <td class="text-center"><?=$row['nama_pasien'];?></td>
                                      <td class="text-center"><?=$row['alamat'];?></td>
                                      <td class="text-center">
                                        <form method="POST">
                                          <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>">
                                            <i class="fas fa-edit"></i> Edit</button>

                                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['kode_kriteria'] ?>?');">
                                              <i class="fas fa-trash-alt"></i> Delete</button>
                                         </form>
                                      </td>
                                    </tr>

                                  <?php $i=$i+1;
                                  endwhile; ?>                     
                        </tbody>
                      </table> 
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

          <!-- Modal Tambah Data -->
              <div class="modal fade" id="modalTambah" tabindex="-2" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header modal-bg bg-primary text-white" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Form Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label for="kode_kriteria" class="col-form-label">Kode Kriteria:</label>
                              <input type="text" class="form-control mt-1" id="kode_kriteria" name="kode_kriteria" required>
                            </div>

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama Kriteria:</label>
                              <input type="text" class="form-control mt-1" id="nama" name="nama"  required>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="tambah" class="btn btn-primary">Insert</button>
                            </div>
                          </form>
                        </div>
                    </form>
                  </div>
                </div>
              </div>

               <!-- Modal Edit Data -->
              <?php foreach ($kriteria as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning text-white" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Kriteria</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                          <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">
                          <input type="hidden" name="kode_kriteria" class="form-control" value="<?=$row['kode_kriteria'] ?>">

                          <div class="form-group"> 
                            <label>Kriteria <?=$row['kode_kriteria'] ?> : </label>
                            <input type="text" name="nama" class="form-control" value="<?=$row['nama'] ?>" required>
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

<?php include('../templetes/footer-admin.php'); ?>
