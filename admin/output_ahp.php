<?php 
if(!isset($_SESSION)) {
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
}

  $page = "kriteria";
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Hasil Perhitungan AHP</h1>
        <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="kriteria.php">Kriteria</a></div>
              <div class="breadcrumb-item active"><a href="bobot_kriteria.php">Perbandingan Kriteria</a></div>
              <div class="breadcrumb-item">Hasil Perhitungan AHP</div>
            </div>
      </div>
      <!-- Begin form content -->
      <div class="section-body">
           <div class="card">
              <div class="card-body">
                
              	<h5 class="ui header">Matriks Perbandingan Berpasangan</h5>
              	<table class="table table-bordered" width="100%" cellspacing="0">
              		<thead class="table-info">
              			<tr>
              				<th>Kriteria</th>
              				<?php
              				for ($i=0; $i <= ($n-1); $i++) { 
              					echo "<th>".getKriteriaNama($i)."</th>";
              				}
              				?>
              			</tr>
              		</thead>
              		<tbody>
              			<?php
              			for ($x=0; $x <= ($n-1); $x++) { 
              				echo "<tr>";
              				echo "<th class='table-info'>".getKriteriaNama($x)."</td>";
              				for ($y=0; $y <= ($n-1); $y++) { 
              					echo "<td>".round($matrik[$x][$y],5)."</td>";
              				}
              				echo "</tr>";
              			}
              			?>
              		</tbody>
              		<tfoot>
              			<tr>
              				<th class="table-secondary"><b>Jumlah(Culumn Sums)</b></th>
              				<?php
              				for ($i=0; $i <= ($n-1); $i++) { 
              					echo "<th>".round($jmlmpb[$i],5)."</th>";
              				}
              				?>
              			</tr>
              		</tfoot>
              	</table>

              <br>

              <h5 class="ui header">Normalisasi</h5>
              <table class="table table-bordered" width="100%" cellspacing="0">
              	<thead class="table-info">
              		<tr>
              			<th>Kriteria</th>
              			<?php
              			for ($i=0; $i <= ($n-1); $i++) { 
              				echo "<th>".getKriteriaNama($i)."</th>";
              			}
              			?>
              			<th>Jumlah</th>
              			<th>Nilai Bobot Kriteria (Priority Value)</th>
              		</tr>
              	</thead>

              	<tbody>
              		<?php for ($x=0; $x <= ($n-1); $x++) { 
              			echo "<tr>";
              			echo "<th class='table-info'>".getKriteriaNama($x)."</th>";
              			for ($y=0; $y <= ($n-1); $y++) { 
              				echo "<td>".round($matrikb[$x][$y],5)."</td>";
              			}
              			echo "<td>".round($jmlmnk[$x],5)."</td>";
              			echo "<td>".round($pv[$x],5)."</td>";

              			echo "</tr>";
              		}
              		?>
              	</tbody>


              	<tfoot>
              		<tr>
              			<th class="table-secondary" colspan="<?php echo ($n+2)?>"><b>Nilai Eigen Maksimum(λ maks)</b></th>
              			<th><?php echo (round($eigenvektor,5))?></th>
              		</tr>
              		<tr>
              			<th class="table-secondary" colspan="<?php echo ($n+2)?>"><b>Indek Konsitensi atau Consistency Index(CI)</b> Rumus: (λ maks-n)/(n-1)</th>
              			<th><?php echo (round($consIndex,5))?></th>
              		</tr>
              		<tr>
              			<th class="table-secondary" colspan="<?php echo ($n+2)?>"><b>Rasio Konsitensi atau Consistency Ratio</b> Rumus: CI/RI</th>
              			<!-- <th><?php echo (round(($consRatio),2))?> </th> -->
              			<th><?php echo (round(($consRatio * 100),2))?> %</th>
              		</tr>
              	</tfoot>
              </table>

              <?php
              if ($consRatio > 0.1) {
              	?>

              	<div class="alert alert-danger" role="alert">
              		<div class="header"> <i class="fas fa-exclamation-triangle"></i> Nilai <b><em>Consistency Ratio </em>> 10%!!! </b>
              			Mohon input kembali tabel perbandingan.
              		</div>
              	</div>

              	<a href='javascript:history.back()'>
              		<button class="btn btn-success float-left">
              			<i class="fas fa-angle-double-left"></i>
              			Kembali
              		</button>
              	</a>

              </div>
              <!-- /.container-fluid -->
          </div>
          <!-- End of Main Content -->

		          <?php 
		      } else {
		      	?>
		      	<div class="alert alert-success" role="alert">
		      		<div class="header"> <i class="fas fa-check-circle"></i> Nilai <b><em>Consistency Ratio</em></b> memenuhi syarat
		      		</div>
		      	</div>

		      	<a href="parameter_kriteria.php">
		      		<button class="btn btn-success float-right">
		      			Lanjut <i class="fas fa-angle-double-right"></i>
		      		</button>
		      	</a>

		      </div>
		  </div>
		
      </div>
      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php } include('../templetes/footer-admin.php'); ?>
