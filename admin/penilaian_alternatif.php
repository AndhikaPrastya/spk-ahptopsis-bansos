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

 $page = "analisis";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";

  $id1=$_GET['id'];
  $alternatif=query("SELECT * FROM alternatif where id='$id1'")[0];

  if (isset($_POST['nilai'])) {
    // var_dump($_POST);die;
    $krt=query("SELECT * FROM kriteria ORDER BY id");
    foreach ($krt as $key) {
        $id=$_POST['alt'];
        $nm=$key['id'];
        $idkrt='krt'.$nm;
        $krt=$_POST[$idkrt];
        $pram='pram'.$nm;
        $npram=$_POST[$pram];
        // echo "id alternatif ".$id."id kriteria= ".$krt."<br>"." nilai= ".$npram."<br>";
        $query="UPDATE nilai_analisis SET id_parameter=$npram
                where id_alternatif=$id and id_kriteria=$krt";
        mysqli_query($koneksi,$query);
	       echo"
	       <script type='text/javascript'>
	       setTimeout(function(){
	             swal({
	              title: 'Penilaian berhasil ditambahkan!',
	              icon: 'success',
	              timer: 3200,
	              showConfirmButton: true
	              });
	       },10);
	       window.setTimeout(function(){
	       window.location.replace('analisis.php');
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
        <h1>Penilaian Alternatif</h1>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card col-xl-6 col-lg-5">
              <div class="card-footer">
                <h5>Penilaian  : <?=$alternatif['nama'] ?> 
                                [<?=$alternatif['no_kk'] ?>]</h5>
              </div>
              <div class="card-body">
               
              	<form action="#" method="post">
              		<?php  $kriteria=query("SELECT * FROM kriteria ORDER BY id"); 
              		foreach ($kriteria as $row):?>

              			<div  class="form-group row">
              				<label><h7><b>Kriteria [<?=$row['kode_kriteria'] ?>] : <?=$row['nama'] ?></b></h7></label>
              				<input type="hidden" name="alt" value="<?=$alternatif['id'] ?>">
              				<input type="hidden" name="krt<?=$row['id']?>" value="<?=$row['id']?>">

              				<select class="form-control" id="pram" name="pram<?=$row['id']?>">
              					<?php $idk=$row['id'];
              					$parameter=query("SELECT * FROM parameter WHERE id_Kriteria = $idk ORDER BY nilai_parameter DESC"); ?>

              					<?php foreach ($parameter as $row1):?>
              						 <option value="<?= $row1['id_parameter']; ?>"><?= $row1['nama_parameter']; ?></option>
              						<?php endforeach; ?>
              					</select>
              				</div>
              			<?php endforeach; ?>

              			<div class="modal-footer">
              				<a class="btn btn-dark" href="alternatif.php" role="button">close</a>
              				<button type="submit" name="nilai" class="btn btn-primary">Insert</button>
              			</div>
              		</form>
            </div>
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php'); ?>