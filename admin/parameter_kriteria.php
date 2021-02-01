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
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Parameter Kriteria</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card shadow">
                <div class="card-footer bg-whitesmoke">
                  <a class="btn btn-success float-right" href="alternatif.php" role="button">Lanjut <i class="fas fa-angle-double-right"></i></a>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped" id="tableData">
                      <thead class="table-info">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kode Kriteria</th>
                      <th class="text-center">Nama Kriteria</th>
                      <th class="text-center">Bobot</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                      <?php  
                        $i=1;
                        $parameter=mysqli_query($koneksi,"SELECT A.id, A.kode_kriteria, A.nama, B.nilai FROM pv_kriteria B JOIN                      kriteria A ON A.id = B.id_kriteria ORDER BY id");
                        while($row = mysqli_fetch_array($parameter)): ?>

                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['kode_kriteria'];?></td>
                        <td class="text-center"><?=$row['nama'];?></td>
                        <td class="text-center"><?=$row['nilai'];?></td>
                        <td class="text-center">
                          <form>
                            <a href="parameter_detail.php?id=<?=$row['id'] ?>" class="btn btn-warning btn-sm" ><i class="fas fa-plus"></i> Detail Parameter</a>
                          </form>
                        </td>
                      </tr>
                     <?php $i=$i+1;
                     endwhile; ?>
                  </tbody>
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


