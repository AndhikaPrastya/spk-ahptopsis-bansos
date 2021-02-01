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

$page = "profil";
include('../templetes/topbar-admin.php');
include('../templetes/sidebar-admin.php');
require_once "../functions.php";
require_once "../config.php";

$id=$_SESSION['id'];
$user=query("SELECT a.id, a.nama, a.email, a.username, a.password, a.id_role, a.time_input, a.row_edit, 
                    a.id_status, b.role 
             FROM user a JOIN role_user b ON a.id_role = b.id WHERE a.id='$id'")[0];

if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataProfile($_POST)>0){
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
       window.location.replace('profil.php');
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
         window.location.replace('profil.php');
         },1500);
         </script>
         ";
      }
}

if(isset($_POST["ubahpass"])) {
  // var_dump($_POST);die;
  if(ubahpass($_POST) > 0){
   echo"
       <script type='text/javascript'>
       setTimeout(function(){
             swal({
              title: 'Password berhasil diubah dan silahkan login kembali!',
              icon: 'success',
              timer: 3200,
              showConfirmButton: true
              });
       },10);
       window.setTimeout(function(){
       window.location.replace('../logout.php');
       },1500);
       </script>
       ";
      }else{
         echo"
          <script type='text/javascript'>
          setTimeout(function(){
             swal({
              title: 'Password gagal diubah!',
              icon: 'error',
              timer: 3200,
              showConfirmButton: true
              });
         },10);
         window.setTimeout(function(){
         window.location.replace('profil.php');
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
        <h1>My Profile</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
           
            <h2 class="section-title">Hi, <?=$user['nama']?>!</h2>

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                   
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?=$user['nama']?> <div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div> <?=$user['role']?></div></div>
                    <i class="fas fa-user"></i> Username : <span><?=$user['username']?></span><br>
                    <i class="fas fa-envelope"></i> Email : <span><?=$user['email']?></span><br>
                    <i class="fas fa-calendar-check"></i> Bergabung sejak : <span><?= date('d M Y', strtotime($user['time_input']))?></span>
                    <br>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEdit"><i class="fas fa-user-edit"></i> Edit Profile</button>

                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" 
                          data-target="#modalPass"><i class="fas fa-key"></i> Change Password</button>
                    
                  </div>
                </div>
              </div>
            </div>
        </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php');?> 
            <!-- Modal Edit Data -->
              
              <div class="modal fade" id="modalEdit" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-info text-white" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Profile</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <input type="hidden" name="id" class="form-control" value="<?=$user['id']?>">
                            <input type="hidden" name="password" class="form-control" value="<?=$user['password']?>">
                            <input type="hidden" name="id_role" class="form-control" value="<?=$user['id_role']?>">
                            <input type="hidden" name="time_input" class="form-control" value="<?=$user['time_input']?>"
                            >
                            <input type="hidden" name="id_status" class="form-control" value="<?=$user['id_status']?>">
                            <input type="hidden" name="nama2" class="form-control" value="<?=$user['nama']?>">
                            <input type="hidden" name="email2" class="form-control" value="<?=$user['email']?>">
                            <input type="hidden" name="username2" class="form-control" value="<?=$user['username']?>">

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama :</label>
                              <input type="text" class="form-control mt-1" name="nama" value="<?=$user['nama']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="email" class="col-form-label">Email :</label>
                              <input type="text" class="form-control mt-1" name="email" value="<?=$user['email']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="username" class="col-form-label">Username :</label>
                              <input type="text" class="form-control mt-1" name="username" value="<?=$user['username']?>" required>
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




      <div class="modal fade" id="modalPass" tabindex="-2" role="dialog" aria-labelledby="modalPassTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                  <div class="modal-header modal-bg bg-success text-white" back>
                        <h5 class="modal-title modal-text text-white" id="modalPassTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form >
                         <input type="hidden" name="id" id="id" value="<?=$_SESSION['id']?>">
                         <div class="form-group">
                           <label for="password_old" class="col-form-label text-dark"> Password Sebelumnya : </label>
                           <input type="password" class="form-control mt-1" id="password_old" name="password_old"  required>
                         </div>
                         <div class="form-group">
                           <label for="password1" class="col-form-label text-dark"> Password Baru : </label>
                           <input type="password" class="form-control mt-1" id="password1" name="password1"  required>
                         </div>
                         <div class="form-group">
                           <label for="password2" class="col-form-label text-dark">Konfirmasi Password Baru : </label>
                           <input type="password" class="form-control mt-1" id="password2" name="password2"  required>
                         </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="ubahpass" class="btn btn-primary">Change Password</button>
                      </div>
                        </form>
                      </div>
                    </form>
                  </div>
                </div>
              </div>



