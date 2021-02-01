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

  $page = "user";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";


  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataUser1($_POST)>0){
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
       window.location.replace('r_user.php');
       },3000);
       </script>
       ";
      }else{
       echo"
          <script type='text/javascript'>
          setTimeout(function(){
             swal({
              title: 'Data gagal dihapus!',
              icon: 'error',
              timer: 3200,
              showConfirmButton: true
              });
         },10);
         window.setTimeout(function(){
         window.location.replace('r_user.php');
         },3000);
         </script>
         ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataStatus($_POST)>0){
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
       window.location.replace('user.php');
       },3000);
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
         window.location.replace('r_user.php');
         },3000);
         </script>
         ";
      }
}
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Recycle Bin Data User</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card">
              <div class="card-body">
                
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="tableData">
                  <thead class="table-info">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">Username</th>
                      <th class="text-center">Role</th>
                      <th class="text-center">Tanggal Bergabung</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php  
                          $i=1;
                          $user=mysqli_query($koneksi,"SELECT a.id ,a.nama, a.email, a.username, a.time_input, a.id_status, b.role, c.kondisi FROM user a JOIN role_user b ON a.id_role = b.id JOIN status c ON a.id_status = c.id WHERE id_status = 2 ORDER BY time_input DESC");

                          while($row = mysqli_fetch_array($user)): ?>

                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['nama'];?></td>
                        <td class="text-center"><?=$row['email'];?></td>
                        <td class="text-center"><?=$row['username'];?></td>
                        <td class="text-center"><?=$row['role'];?></td>
                        <td class="text-center"><?= date('d M Y', strtotime($row['time_input']));?></td>
                        <td class="text-center"><?=$row['kondisi'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                            <button type="submit" name="edit" class="btn btn-info btn-sm" onclick="return confirm('yakin restore data <?=$row['username'] ?>?');">
                            <i class="fas fa-trash-restore"></i> Restore</button>

                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['username'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>
                          </form>

                        </td>
                      </tr>
                      <?php $i=$i+1;
                      endwhile; ?> 
                  </tbody>
                </table>
                </div>
              </div>
              <div class="card-footer bg-whitesmoke">
                 <a class="btn btn-success float-left "href="user.php" role="button">
                                  <i class="fas fa-angle-double-left"></i> Kembali</a>
              </div>
              </div>
            </div>
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php'); ?>

        