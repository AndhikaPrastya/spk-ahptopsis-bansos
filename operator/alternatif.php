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
    $page = "alternatif";
    include('../templetes/topbar-operator.php');
    include('../templetes/menubar-operator.php');
    require_once "../functions.php";
    require_once "../config.php";

$id=$_SESSION['id'];
$user=query("SELECT id, nama FROM user WHERE id='$id'")[0];

if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataAlternatif($_POST)>0){
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
       window.location.replace('alternatif.php');
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
         window.location.replace('alternatif.php');
         },1500);
         </script>
         ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataAlternatif2($_POST)>0){
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
       window.location.replace('alternatif.php');
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
       window.location.replace('alternatif.php');
       },1500);
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataAlternatif($_POST)>0){
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
       window.location.replace('alternatif.php');
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
         window.location.replace('alternatif.php');
         },1500);
         </script>
         ";
      }
}

?>

 <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Alternatif</h1>
          </div>

          <div class="section-body">
            
            <div class="card">
              <div class="card-footer bg-whitesmoke">
               
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i> Tambah Kriteria</button>

                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalImport"> <i class="fas fa-file-excel"></i> Import Excel</button>

                <a href="../download.php" class="btn btn-warning"><i class="fas fa-download"></i> Template Form Alternatif</a>
               
                <a class="btn btn-success float-right " href="analisis.php" role="button">Lanjut <i class="fas fa-angle-double-right"></i></a>
              </div>
              <div class="card-body">
              	<div class="table-responsive">
                      <table class="table table-striped" id="tableData">
                        <thead class="table-info">
                           <tr>
                             <th class="text-center">No</th>
                             <th class="text-center">No KK</th>
                             <th class="text-center">Nama Warga</th>
                             <th class="text-center">Alamat</th>
                             <th class="text-center">Jumlah Keluarga</th>
                             <th class="text-center">KK Terdaftar</th>
                             <!-- <th class="text-center">Time Input</th> --> 
                             <!-- <th class="text-center">Status</th> -->
                             <th class="text-center">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>  

                             <?php  
                                 $i=1;
                                 $alternatif=mysqli_query($koneksi,"SELECT a.*, b.nama as nama_user, c.kondisi FROM alternatif a JOIN user b ON a.id_user = b.id JOIN status c ON a.id_status = c.id WHERE a.id_status=1 ORDER BY id DESC");
                                 while($row = mysqli_fetch_array($alternatif)): ?>

                                    <tr>
                                      <td class="text-center"><?=$i;?></td>
                                      <td class="text-center"><?=$row['no_kk'];?></td>
                                      <td class="text-center"><?=$row['nama'];?></td>
                                      <td class="text-center"><?=$row['alamat'];?></td>
                                      <td class="text-center"><?=$row['jml_keluarga'];?> Orang</td>
                                      <td class="text-center"><?= date('d M Y',$row['kk_terdaftar']);?></td>
                                      <!-- <td class="text-center"><?= date('d M Y H:i:s', strtotime($row['time_input']));?></td> -->
                                      <!-- <td class="text-center"><?=$row['kondisi'];?></td> -->
                                      <td class="text-center">
                                        <form method="POST">
                                          <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>"> 
                                            <i class="fas fa-edit"></i> Edit</button>

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
              </div>
              <div class="card-footer bg-whitesmoke">
              </div>
            </div>
          </div>
        </section>
      </div>

<?php include('../templetes/footer-operator.php'); ?>

<!-- Modal Tambah Data -->
              <div class="modal fade" id="modalTambah" tabindex="-2" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered role="document">
                  <div class="modal-content ">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header modal-bg bg-primary text-white" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Form Alternatif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <input type="hidden" class="form-control mt-1" id="id" name="id">
                            <input type="hidden" class="form-control mt-1" id="id_user" name="id_user" 
                                   value="<?= $user['id'] ?>">

                            <div class="form-group">
                              <label for="no_kk" class="col-form-label">No KK :</label>
                              <input type="text" class="form-control mt-1" id="no_kk" name="no_kk"  required>
                            </div>

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama Alternatif :</label>
                              <input type="text" class="form-control mt-1" id="nama" name="nama" required>
                            </div>

                            <div class="form-group">
                              <label for="alamat" class="col-form-label">Alamat :</label>
                              <textarea  type="text" class="form-control" id="alamat" name="alamat" 
                                         required></textarea>
                            </div>

                            <div class="form-group">
                              <label for="jml_keluarga" class="col-form-label">Jumlah Keluarga :</label>
                              <input type="number" class="form-control mt-1" id="jml_keluarga" name="jml_keluarga" min="1" required>
                            </div>

                            <input class="input100" type="hidden" name="time_input" id="time_input" 
                                                        value="<?=date("Y-m-d H:i:s"); ?>">
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
              <?php foreach ($alternatif as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning text-white" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Alternatif</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">
                            <input type="hidden" name="no_kk2" class="form-control" value="<?=$row['no_kk']?>">
                            <input type="hidden" name="nama2" class="form-control" value="<?=$row['nama']?>">
                            <input type="hidden" name="alamat2" class="form-control" value="<?=$row['alamat']?>">
                            <input type="hidden" name="jml_keluarga2" class="form-control" value="<?=$row['jml_keluarga']?>">
                            <input type="hidden" name="kk_terdaftar2" class="form-control" value="<?=$row['kk_terdaftar']?>">
                            <input type="hidden" name="id_user2" class="form-control" value="<?=$row['id_user']?>">
                            <input type="hidden" name="time_input" class="form-control" value="<?=$row['time_input']?>">
                            <input type="hidden" name="id_user" class="form-control" value="<?= $user['id'] ?>">

                            <div class="form-group">
                              <label for="no_kk" class="col-form-label">No KK :</label>
                              <input type="text" class="form-control mt-1" name="no_kk" value="<?=$row['no_kk'] ?>" required>
                            </div>

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama Alternatif :</label>
                              <input type="text" class="form-control mt-1" name="nama" value="<?=$row['nama'] ?>" required>
                            </div>

                            <div class="form-group">
                              <label for="alamat">Alamat :</label>
                              <textarea type="text" class="form-control" name="alamat" rows="3" required><?=$row['alamat'] ?></textarea>
                            </div>

                             <div class="form-group">
                              <label for="jml_keluarga" class="col-form-label">Jumlah Keluarga :</label>
                              <input type="number" class="form-control mt-1" id="jml_keluarga" name="jml_keluarga" min="1" value="<?=$row['jml_keluarga'] ?>" required>
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

              <!-- Modal Iport Data Excel -->
              <div class="modal fade" id="modalImport" tabindex="-2" role="dialog" aria-labelledby="modalImportTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered role="document">
                  <div class="modal-content ">
                    <form method="post" enctype="multipart/form-data" action="upload_aksi.php">
                      <div class="modal-header modal-bg bg-info text-white" back>
                        <h5 class="modal-title modal-text" id="modalImportTitle">Form Import Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label>File</label>
                              <input name="filealternatif" type="file" class="form-control" required="required">
                            </div>
                            <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             <button type="submit" name="upload" class="btn btn-primary">Import</button>
                           </div>
                          </form>
                        </div>
                    </form>
                  </div>
                </div>
              </div>  
