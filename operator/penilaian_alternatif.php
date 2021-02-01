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

    $page = "analisis";
    include('../templetes/topbar-operator.php');
    include('../templetes/menubar-operator.php');
    require_once "../functions.php";
    require_once "../config.php";

  $id1=$_GET['id'];
  $alternatif=query("SELECT * FROM alternatif where id='$id1'")[0];

  if (isset($_POST['nilai'])) {
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

	<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Penilaian Alternatif</h1>
          </div>

          <div class="section-body">
          	<div class="card">
              <div class="card-footer bg-whitesmoke">
                <h5>Penilaian  : <?=$alternatif['nama'] ?> 
                                [<?=$alternatif['no_kk'] ?>]</h5>
              </div>
               <div class="card">
                 <div class="card-body">

                 	<form action="#" method="post">
              		<?php  $kriteria=query("SELECT * FROM kriteria ORDER BY id"); 
              		foreach ($kriteria as $row):?>

              			<div  class="form-group row">
              				<label><h7 class="text-primary"><b>Kriteria [<?=$row['kode_kriteria'] ?>] : <?=$row['nama'] ?></b></h7></label>
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

              			<div class="modal-footer bg-whitesmoke">
              				<a class="btn btn-dark" href="analisis.php" role="button">close</a>
              				<button type="submit" name="nilai" class="btn btn-primary">Insert</button>
              			</div>
              		</form>
              	</div>
              </div>
          </div>
      </div>
  </section>
</div>
<?php include('../templetes/footer-operator.php'); ?>