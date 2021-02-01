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

  $page = "parameter";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";

  $id=$_GET['id'];
  $kriteria=query("SELECT id, kode_kriteria FROM kriteria where id='$id'")[0];

if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataParameter($_POST)>0){
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
       window.location.replace('parameter_detail.php?id=$id');
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
         window.location.replace('parameter_detail.php?id=$id');
         },1500);
         </script>
         ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataParameter($_POST)>0){
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
       window.location.replace('parameter_detail.php?id=$id');
       },1500);
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
       window.location.replace('parameter_detail.php?id=$id');
       },1500);
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataParameter($_POST)>0){
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
       window.location.replace('parameter_detail.php?id=$id');
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
         window.location.replace('parameter_detail.php?id=$id');
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
        <h1>Parameter Kriteria <?=$kriteria['kode_kriteria']?></h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body"> 
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-footer">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i>
                      Tambah Parameter
                    </button>
    
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tableData">
                        <thead class="table-info">
                           <tr>
                              <th class="text-center">No</th>
                              <th class="text-center">Parameter</th>
                              <th class="text-center">Nilai</th>
                              <th class="text-center">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>  

                             <?php  
                                 $i=1;
                                 $parameter=mysqli_query($koneksi,"SELECT * FROM parameter WHERE id_kriteria='$id'");
                                 while($row = mysqli_fetch_array($parameter)): ?>

                                  <tr>
                                    <td class="text-center"><?=$i;?></td>
                                    <td class="text-center"><?=$row['nama_parameter'];?></td>
                                    <td class="text-center"><?=$row['nilai_parameter'];?></td>
                                    <td class="text-center">
                                      <form method="post">
                                        <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_parameter']; ?>">
                                          <i class="fas fa-edit"></i> Edit</button>

                                          <input type="hidden" name="id_parameter" value="<?=$row['id_parameter'];?>">
                                          <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nama_parameter'] ?>?');">
                                            <i class="fas fa-trash-alt"></i> Delete</button>
                                          </form>
                                        </td>
                                      </tr>

                                  <?php $i=$i+1;
                                  endwhile; ?>                     
                        </tbody>
                      </table> 

                      <div class="card-footer">
                        <a class="btn btn-success float-left" href="parameter_kriteria.php" role="button"><i class="fas fa-angle-double-left"> Kembali</i></a>
                      </div>
          </div>
          <!-- End form content -->
      </section>
    </div>
    <!-- End Main Content -->

    <!-- Modal Tambah Data -->
              <div class="modal fade" id="modalTambah" tabindex="-2" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                      <div class="modal-header modal-bg bg-primary text-white" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Form Tambah Parameter <?=$kriteria['kode_kriteria']?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <input type="hidden" name="id_kriteria" class="form-control" value="<?=$kriteria['id'] ?>">
                            <div class="form-group">

                                  <div class="form-row">
                                    <div class="form-group col-md-8">
                                      <label for="nama_parameter">Parameter</label>
                                      <input type="text" class="form-control" id="nama_parameter" name="nama_parameter"  autofocus required>
                                    </div>

                                    <div class="form-group col-md-4">
                                      <label for="nilai_parameter">Nilai</label>
                                      <select id="nilai_parameter" name="nilai_parameter" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                      </select>
                                    </div>
                                  </div>

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
             <?php foreach ($parameter as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id_parameter'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
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

                            <div class="form-group">
                              <input type="hidden" name="id_parameter" class="form-control" value="<?=$row['id_parameter'] ?>">
                              <input type="hidden" name="id_kriteria" class="form-control" value="<?=$row['id_kriteria'] ?>">

                                  <div class="form-row">
                                    <div class="form-group col-md-8">
                                      <label for="nama_parameter">Parameter</label>
                                      <input type="text" class="form-control" name="nama_parameter" value="<?=$row['nama_parameter'] ?>" required>
                                      </div>  
                                    
                                    <div class="form-group col-md-4">
                                      <label for="nilai_parameter">Nilai</label>
                                      <select name="nilai_parameter" class="form-control">
                                        <option value="1" <?php if($row['nilai_parameter'] == "1") {echo "selected";} ?> >1</option>
                                        <option value="2" <?php if($row['nilai_parameter'] == "2") {echo "selected";} ?> >2</option>
                                        <option value="3" <?php if($row['nilai_parameter'] == "3") {echo "selected";} ?> >3</option>
                                        <option value="4" <?php if($row['nilai_parameter'] == "4") {echo "selected";} ?> >4</option>
                                        <option value="5" <?php if($row['nilai_parameter'] == "5") {echo "selected";} ?> >5</option>
                                        <option value="6" <?php if($row['nilai_parameter'] == "6") {echo "selected";} ?> >6</option>
                                        <option value="7" <?php if($row['nilai_parameter'] == "7") {echo "selected";} ?> >7</option>
                                        <option value="8" <?php if($row['nilai_parameter'] == "8") {echo "selected";} ?> >8</option>
                                        <option value="9" <?php if($row['nilai_parameter'] == "9") {echo "selected";} ?> >9</option>
                                      </select>
                                    </div>
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

<?php include('../templetes/footer-admin.php'); ?>
