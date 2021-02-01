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
  $page = "alternatif";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";


  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataAlternatif($_POST)>0){
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
       window.location.replace('r_alternatif.php');
       },1500);
       </script>
       ";
      }else{
      echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data gagal dihapus!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('r_alternatif.php');
       },1500);
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataAlternatif2($_POST)>0){
    echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Data berhasil direstore!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('alternatif.php');
       },1500);
       </script>
       ";
      }else{
         echo"
          <script type='text/javascript'>
          setTimeout(function(){
             swal({
              title: 'Data gagal direstore!',
              icon: 'error',
              timer: 3200,
              showConfirmButton: true
              });
         },10);
         window.setTimeout(function(){
         window.location.replace('r_alternatif.php');
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
        <h1>Alternatif</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body"> 
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-footer bg-whitesmoke">
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tableData">
                        <thead class="table-info">
                           <tr>
                             <th class="text-center">No</th>
                             <th class="text-center">No KK</th>
                             <th class="text-center">Nama Alternatif</th>
                             <th class="text-center">Alamat</th>
                             <th class="text-center">Terdaftar</th>
                             <th class="text-center">Status</th>
                             <th class="text-center">Creator</th>
                             <th class="text-center">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>  

                             <?php  
                                 $i=1;
                                 $alternatif=mysqli_query($koneksi,"SELECT a.*, b.nama as nama_user, c.kondisi FROM alternatif a JOIN user b ON a.id_user = b.id JOIN status c ON a.id_status = c.id WHERE a.id_status=2 ORDER BY id DESC");
                                 while($row = mysqli_fetch_array($alternatif)): ?>

                                    <tr>
                                      <td class="text-center"><?=$i;?></td>
                                      <td class="text-center"><?=$row['no_kk'];?></td>
                                      <td class="text-center"><?=$row['nama'];?></td>
                                      <td class="text-center"><?=$row['alamat'];?></td>
                                      <td class="text-center"><?= date('d M Y H:i:s', strtotime($row['time_input']));?></td>
                                      <td class="text-center"><?=$row['kondisi'];?></td>
                                      <td class="text-center"><?=$row['nama_user'];?></td>
                                      <td class="text-center">
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                                            <button type="submit" name="edit" class="btn btn-info btn-sm" onclick="return confirm('yakin restore data <?=$row['nama'] ?>?');">
                                              <i class="fas fa-trash-restore"></i> Restore</button>

                                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nama'] ?>?');">
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
    </div>
        <div class="card-footer bg-whitesmoke">
         <a class="btn btn-success float-left " href="alternatif.php" role="button"><i class="fas fa-angle-double-left"></i> Kembali</a>
       </div>
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php'); ?> 
