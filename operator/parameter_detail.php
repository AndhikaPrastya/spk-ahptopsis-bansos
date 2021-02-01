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

    $page = "kriteria";
    include('../templetes/topbar-operator.php');
    include('../templetes/menubar-operator.php');
    require_once "../functions.php";
    require_once "../config.php";

  $id=$_GET['id'];
  $kriteria=query("SELECT id, kode_kriteria FROM kriteria where id='$id'")[0];
?>

<!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Parameter Kriteria <?=$kriteria['kode_kriteria']?></h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-body">
              	<div class="table-responsive">
                      <table class="table table-striped" id="tableData">
                        <thead class="table-info">
                           <tr>
                              <th class="text-center">No</th>
                              <th class="text-center">Parameter</th>
                              <th class="text-center">Nilai</th>
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
                                  </tr>
                                  <?php $i=$i+1;
                                  endwhile; ?>                     
                        </tbody>
                      </table> 
					</div>
				</div>
				<div class="card-footer bg-whitesmoke">
					<a class="btn btn-success float-left" href="kriteria.php" role="button"><i class="fas fa-angle-double-left"> Kembali</i></a>
				</div>
			</div>
		</div>
	</section>
</div>

<?php include('../templetes/footer-operator.php'); ?>

