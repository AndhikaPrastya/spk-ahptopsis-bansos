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
  if(hapusDataUser2($_POST)>0){
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
       window.location.replace('user.php');
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
         window.location.replace('user.php');
         },3000);
         </script>
         ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataRole($_POST)>0){
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
       window.location.replace('user.php');
       },3000);
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
         window.location.replace('user.php');
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
        <h1>User</h1>
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
                          $user=mysqli_query($koneksi,"SELECT a.id ,a.nama, a.email, a.username, a.time_input, a.id_status, b.role, c.kondisi FROM user a JOIN role_user b ON a.id_role = b.id JOIN status c ON a.id_status = c.id WHERE id_status = 1 ORDER BY time_input DESC");
                          while($row = mysqli_fetch_array($user)): ?>

                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['nama'];?></td>
                        <td class="text-center"><?=$row['email'];?></td>
                        <td class="text-center"><?=$row['username'];?></td>
                        <td class="text-center"><?=$row['role'];?></td>
                        <td class="text-center"><?= date('d M Y H:i:s', strtotime($row['time_input']));?></td>
                        <td class="text-center"><?=$row['kondisi'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>">
                            <i class="fas fa-edit"></i> Edit Role</button>

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
               <a class="btn btn-success float-left " href="r_user.php" role="button"><i class="fas fa-recycle"></i> Recycle Bin</a>
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
              <?php foreach ($user as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning text-white" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Role User</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                          <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">
                          <div class="form-group"> 
                            <label>Nama User : <b><?=$row['nama'] ?></b> </label>
                          
                          <div class="form-group">
                            <label for="role">Role User :</label>
                                <select name="role" class="form-control">
                                    <option value="2" <?php if($row['role'] == "Admin") {echo "selected";} ?> >Admin</option>
                                    <option value="3" <?php if($row['role'] == "Operator") {echo "selected";} ?> >Operator</option>
                                    <option value="1" <?php if($row['role'] == "Disable") {echo "selected";} ?> >Disable</option>
                                </select>
                          </div>
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
