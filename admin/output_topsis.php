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

  $page = "hasil";
  date_default_timezone_set('Asia/Jakarta');
  include('../templetes/topbar-admin.php');
  include('../templetes/sidebar-admin.php');
  require_once "../functions.php";
  require_once "../config.php";

  $kriteria = query("SELECT * FROM kriteria ORDER BY id");
  $hasil=[];

  $jml_kriteria = count($kriteria);
?>

<!-- Begin Main Content -->
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Hasil Perhitungan</h1>
      </div>


      <!-- Begin form content Nilai analisis -->
      <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
              	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseAnalisis" aria-expanded="false" aria-controls="collapseAnalisis">
              		Nilai Analisis
              	</button>
              </div>
              <div class="card-body">
                
              	<div class="collapse" id="collapseAnalisis">
              		<div class="card card-body">

              			<div class="table-responsive">
              				<table class="table table-bordered" width="100%" cellspacing="0" id="tableData">
              					<thead class="table-info">
              						<tr>
              							<th class="text-center table-white align-middle" rowspan="2">ALTERNATIF</th>
              							<th class="text-center" colspan="<?php echo $jml_kriteria; ?>" 
              								>KRITERIA</th>
              							</tr>
              							<tr>
              								<?php foreach ($kriteria as $key1) : ?>
              									<th class="text-center"><?=$key1['kode_kriteria']; ?></th>
              								<?php endforeach; ?>
              							</tr>
              						</thead>
              						<?php $alternatif = query("SELECT * FROM alternatif WHERE id_status=1 ORDER BY id"); ?>
              						<?php foreach ($alternatif as $key2) : ?>
              							<tr>
              								<th class="table-grey"><?=$key2['no_kk']; ?></th>
              								<?php
              								$id=$key2['id'];
              								$analisis = query(" SELECT b.id_alternatif,a.nilai_parameter
              									FROM parameter a JOIN nilai_analisis b USING(id_parameter)
              									WHERE  b.id_alternatif=$id"); 
              									?>
              									<?php foreach ($analisis as $key3) : ?>
              										<td class="text-center"><?=$key3['nilai_parameter']; ?></td>
              										<?php $hasil[][]=$key3['nilai_parameter']; ?>
              									<?php endforeach; ?>
              							</tr>
              							<?php endforeach; ?>
              				</table>
              			</div>
              		</div>
              	</div>
              </div>
            </div>
      </div>
      <!-- /.container-fluid -->

      <?php error_reporting(0); ?>

        <!-- Rumus nilai ternormalisasi -->
        <?php 
          $jmal=query("SELECT * FROM kriteria");
          $alt=query("SELECT * FROM alternatif WHERE id_status=1 ");
          $idd=[];
          foreach ($alt as $keys) {
            $idd[]=$keys['id'];
          }

          $jml=count($idd);
          $hsl=[];
          foreach ($jmal as $key ) {
            $id=$key['id'];
            $nilai=query("SELECT b.id_kriteria,a.nilai_parameter,c.id_status
              FROM parameter a 
              JOIN nilai_analisis b USING(id_parameter) JOIN alternatif c ON b.id_alternatif=c.id
              WHERE  b.id_kriteria=$id AND c.id_status=1");
            foreach ($nilai as $keys) {
              $nn=$keys['nilai_parameter'];
              $hsl[$id][]=pow($nn,2);
            }
          }

          $jumlahakar=[];
          foreach ($jmal as $key) {
            $id=$key['id'];
            $akar=array_sum($hsl[$id]);
            $jumlahakar[$id]=sqrt($akar);
          }

          $normalisasi=[];
          foreach ($alt as $key) {
            $id=$key['id'];
            $nilai_normalisasi = query(" SELECT b.id_alternatif,a.nilai_parameter, a.id_kriteria, c.id_status
              FROM parameter a 
              JOIN nilai_analisis b USING(id_parameter) JOIN alternatif c ON b.id_alternatif=c.id
              WHERE  b.id_alternatif=$id AND c.id_status=1 ");
            foreach ($nilai_normalisasi as $keyy) {
              $id=$keyy['id_kriteria'];
              $idalt=$keyy['id_alternatif'];
              $normalisasi[$id][$idalt]=$keyy['nilai_parameter']/$jumlahakar[$id];
            }
          }

          error_reporting(0);
        ?>

        <!-- Begin form content Nilai Normalisasi-->
        <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseNormalisasi" aria-expanded="false" aria-controls="collapseNormalisasi">
                    Nilai Normalisasi
                  </button>
                </div>
                <div class="card-body">

                <div class="collapse" id="collapseNormalisasi">
                  <div class="card card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableB">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle" rowspan="2">ALTERNATIF</th>
                            <th class="text-center" colspan="<?php echo $jml_kriteria; ?>" 
                              >KRITERIA</th>
                            </tr>
                            <tr>
                              <?php foreach ($kriteria as $key1) : ?>
                                <th class="text-center"><?=$key1['kode_kriteria']; ?></th>
                              <?php endforeach; ?>
                            </tr>
                          </thead>

                            <?php $ts=query("SELECT *FROM kriteria ");
                            $query=query("SELECT*FROM alternatif WHERE id_status=1 ORDER BY id"); ?>
                            <?php foreach ($query as $keyt):?>
                            <?php $i=$keyt['id']; ?>
                            <tr>
                                <th class="table-grey"><?=$keyt['no_kk'];?></th>
                              <?php foreach ($ts as $key) :?> 
                              <?php $id=$key["id"]; ?>
                                  <td class="text-center"><?=$normalisasi[$id][$i];?></td>
                                <?php endforeach; ?>
                              </tr>
                            <?php endforeach; ?>
                          </table>
                        </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Rumus normalisasi terbobot -->
        <?php
        $pf=query("SELECT * FROM pv_kriteria");
        $pv_terbobot=[];
        foreach ($query as $keyp) {
          $ida=$keyp['id'];
          foreach ($pf as $keyd) {
            $ai=$keyd['id_kriteria'];
            $pv_terbobot[$ai][$ida]=$normalisasi[$ai][$ida]*$keyd['nilai'];
          }
        }
        ?>

        <!-- Tabel Nilai Terbobot -->
        <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTerbobot" aria-expanded="false" aria-controls="collapseTerbobot">
                    Nilai Normalisasi Bobot AHP
                  </button>
                </div>
                <div class="card-body">

                <div class="collapse" id="collapseTerbobot">
                  <div class="card card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableC">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle" rowspan="2">ALTERNATIF</th>
                            <th class="text-center" colspan="<?php echo $jml_kriteria; ?>" 
                              >KRITERIA</th>
                            </tr>
                            <tr>
                              <?php foreach ($kriteria as $key1) : ?>
                                <th class="text-center"><?=$key1['kode_kriteria']; ?></th>
                              <?php endforeach; ?>
                            </tr>
                          </thead>
                          <?php $query=query("SELECT*FROM alternatif WHERE id_status=1 ORDER BY id"); ?>
                          <?php foreach ($query as $keyt):?>
                          <?php $i=$keyt['id']; ?>
                            <tr>
                                <th class="table-grey"><?=$keyt['no_kk'];?></th>
                              <?php foreach ($ts as $key) :?> 
                              <?php $id=$key["id"]; ?>
                                  <td class="text-center"><?=$pv_terbobot[$id][$i];?></td>
                                <?php endforeach; ?>
                              </tr>
                            <?php endforeach; ?>
                      </table>
                    </div>

                  </div>
                </div>
                 
                </div>
              </div>
        </div>

        <!-- /.container-fluid -->

        <!-- Rumus solusi ideal -->
        <?php 
        $px=query("SELECT*FROM kriteria");
        $solusi_max=[];
        $solusi_min=[];
        foreach ($px as $key ) {
          $is=$key['id'];
          $cek=$pv_terbobot[$is];
          $solusi_max[$is]=max($cek);
          $solusi_min[$is]=min($cek);
        }
        ?>

        <!-- Tabel solusi ideal -->
       <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseSolusi" aria-expanded="false" aria-controls="collapseSolusi">
                    Nilai Solusi Ideal
                  </button>
                </div>
                <div class="card-body">

                <div class="collapse" id="collapseSolusi">
                  <div class="card card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableD">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle" rowspan="2">SOLUSI IDEAL</th>
                            <th class="text-center" colspan="<?php echo $jml_kriteria; ?>" 
                              >KRITERIA</th>
                            </tr>
                            <tr>
                              <?php foreach ($kriteria as $key1) : ?>
                                <th class="text-center"><?=$key1['kode_kriteria']; ?></th>
                              <?php endforeach; ?>
                            </tr>
                          </thead>
                            <tr>
                                <th class="table-grey">Positif</th>
                                <?php foreach ($px as $keya) :?>
                                <?php $is=$keya['id']; ?>
                                  <td class="text-center"><?=$solusi_max[$is];?></td>
                                <?php endforeach; ?>
                              </tr>
                            <tr>
                                <th class="table-grey">Negatif</th>
                                <?php foreach ($px as $keya) :?>
                                <?php $is=$keya['id']; ?>
                                  <td class="text-center"><?=$solusi_min[$is];?></td>
                                <?php endforeach; ?>
                              </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Rumus jarak solusi -->
        <?php 
        $n_jarak_max=[];
        foreach ($query as $ke) {
          $is=$ke['id'];
          foreach ($ts as $kk) {
            $idk=$kk['id'];
            $n_jarak_max[$is][]=pow($pv_terbobot[$idk][$is]-$solusi_max[$idk],2) ;
          }

        }
        $n_jarak_min=[];
        foreach ($query as $ke) {
          $is=$ke['id'];
          foreach ($ts as $kk) {
            $idk=$kk['id'];
            $n_jarak_min[$is][]=pow($pv_terbobot[$idk][$is]-$solusi_min[$idk],2) ;
          }

        }
        $n_jrk_total=[];
        foreach ($query as $k) {
          $idk=$k['id'];
          $ik=array_sum($n_jarak_max[$idk]);
          $n_jrk_total[$idk]['max']=sqrt(array_sum($n_jarak_max[$idk]));
          $n_jrk_total[$idk]['min']=sqrt(array_sum($n_jarak_min[$idk]));
        }
        ?>

         <!-- Tabel jarak solusi -->
        <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseJarak" aria-expanded="false" aria-controls="collapseJarak">
                    Nilai Jarak Solusi
                  </button>
                </div>
                <div class="card-body">

                <div class="collapse" id="collapseJarak">
                  <div class="card card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableE">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle">ALTERNATIF</th>
                            <th class="text-center table-white align-middle">D+</th>
                            <th class="text-center table-white align-middle">D-</th>
                          </tr>
                        </thead>
                          <?php foreach ($query as $key) :?>
                          <?php $id=$key['id']; ?>
                            <tr>
                              <th><?=$key['no_kk']?></th>
                              <td class="text-center"><?=$n_jrk_total[$id]['max']?></td>
                              <td class="text-center"><?=$n_jrk_total[$id]['min']?></td>
                            </tr>
                          <?php endforeach; ?>  
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Rumus preferensi -->
        <?php
        $hasil=[]; 
        foreach ($query as $tg) {
          $id=$id=$tg['id'];
          $hasil[$id]=$n_jrk_total[$id]['min']/($n_jrk_total[$id]['min']+$n_jrk_total[$id]['max']);
        }
        ?>

        <!-- Tabel preferensi -->
        <div class="section-body">
           <div class="card">
              <div class="card-footer bg-whitesmoke">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsV" aria-expanded="false" aria-controls="collapsV">
                    Nilai Preferensi
                  </button>
                </div>
                <div class="card-body">

                <div class="collapse" id="collapsV">
                  <div class="card card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered" width="100%" cellspacing="0" id="tableF">
                        <thead class="table-info">
                          <tr>
                            <th class="text-center table-white align-middle">Alternatif</th>
                            <th class="text-center table-white align-middle">Nilai Preferensi</th>
                          </tr>
                        </thead>
                        <?php foreach ($query as $key) :?>
                          <?php $id=$key['id']; ?>
                            <tr>
                              <th><?=$key['no_kk']?></th>
                              <td class="text-center"><?=$hasil[$id]?></td>
                            </tr>
                          <?php endforeach; ?>  
                      </table>
                    </div>
                  </div>
                </div>
             </div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
             <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modalLaporan"> <i class="fas fa-save"></i> Simpan Hasil Seleksi</button>
        </div>
        <!-- /.container-fluid -->

        <!--  tambah nilai ke tabel -->

       <?php 

        if (isset($_POST["laporan"])) {
         // var_dump($_POST); die;
       
        $nama = htmlspecialchars($_POST["nama"]);
        $time_input =date("Y-m-d H:i:s");
        $kuota = $_POST["kuota"];
      
        $query1 = "INSERT INTO laporan VAlUES ('','$nama','$time_input','$kuota')";
        mysqli_query($koneksi,$query1);

        $result = mysqli_query($koneksi, "SELECT * FROM laporan group by id_laporan DESC limit 0,1 ");
        $ambil = mysqli_fetch_assoc($result);
        $id_laporan=$ambil['id_laporan'];

        foreach ($hasil as $id_alt => $nilai_v) {

              $query = "INSERT INTO hasil VALUES ( '','$id_alt', '$nilai_v', '$id_laporan') ";
              // var_dump($query);
              mysqli_query($koneksi,$query);
              }

        // Seleksi Jika Nilai Sama
        //================================ 

              $kriteria1=query("SELECT a.id,a.kode_kriteria,b.nilai FROM kriteria a 
                                JOIN pv_kriteria b ON a.id=b.id_kriteria ORDER BY b.nilai DESC");
              $kriterialop=[];
              foreach ($kriteria1 as $keyx) {
                $kriterialop[]=$keyx['kode_kriteria'];
              }

              $hasil=query("SELECT * From hasil WHERE id_laporan=$id_laporan ORDER By nilai DESC");
              $hsl=[];
              foreach ($hasil as $key) {
                $id=$key['id_alternatif'];
                $value=$key['nilai'];
                $hsl[$id]=$value;
              }

              $kunci=[];
              $nilai=[];
              foreach ($hsl as $key1 => $value1) {
                $nilai[]=$value1;
                $kunci[]=$key1;
              }

              function findDuplocates($data){
                return $data>1;
              }

              $duplicat=array_filter(array_count_values($nilai),"findDuplocates");
              $bykdup=count($duplicat);

              if ($bykdup>0) {
                $cek=[];
                foreach ($duplicat as $key2 => $value2) {
                  $cek[]= array_keys($nilai,"$key2",false);  
                }

                $ki=[];
                $kii=[];
                $kiii=[];
                foreach ($cek as $key3 => $value3) {
                  foreach ($value3 as $key4 => $value4) {
                    $id=$cek[$key3][$key4];
                    $knc=array_values($kunci);
                    $ki[$key3][]=$knc[$id];
                    $kii[]=$knc[$id];
                  }
                }

                foreach ($cek as $key5 => $value5) {
                  foreach ($value5 as $key6 => $value6) {
                    $kiii[]=$value6;
                  }
                }

                $jmldata=count($ki);
                $kis=[];
                $kiis=[];
                $data_N_K=[];
                foreach ($kii as $key7 => $value7) {
                  $hasil2=query("SELECT a.id,a.jml_keluarga,a.kk_terdaftar,a.time_input,b.kode_kriteria,d.nilai_parameter 
                    FROM alternatif a 
                    RIGHT JOIN nilai_analisis c ON a.id=c.id_alternatif 
                    LEFT JOIN kriteria b ON c.id_kriteria=b.id 
                    JOIN parameter d ON c.id_parameter=d.id_parameter WHERE a.id='$value7'");

                  foreach ($hasil2 as $key8) {
                    $ktr=$key8['kode_kriteria'];
                    $alt=$key8['id'];
                    $data_N_K[$alt][$ktr]=$key8['nilai_parameter'];
                    $jml_keluarga[$alt]=$key8['jml_keluarga'];
                    $kk_terdaftar[$alt]=$key8['kk_terdaftar'];
                    $time_input[$alt]=$key8['time_input'];
                  }
                }

                foreach ($duplicat as $key9 => $value9) {
                  $l=1;
                  $dex=0;
                  if (isset($_POST['index_b'])) {
                    $dex=$_POST['index_b'];
                    $value9=$dex+$$value9;
                    $l=$_POST['index_l']+$l;
                  }

                  for ($ia=$dex; $ia < $value9; $ia++) { 
                    $bj=$ia+1;
                    if ($bj===$value9) {
                      $_POST['index_b']=$value9;
                      $_POST['index_l']=1;
                    }

                    for ($i=$bj; $i < $value9 ; $i++) {
                      $A=$kii[$ia];
                      $B=$kii[$i];
                      $Ai=$kiii[$ia];
                      $Bi=$kiii[$i];
                      $bataslop=count($kriterialop);
                      $cekkeluarga=false;
                      $cekkk=false;
                      $cektime=false;
                      // echo "<br>alternatif A ".$A." alternatif B ".$B."<br>";
                      for ($btsloop=0; $btsloop < $bataslop; $btsloop++) { 
                        $idkrt=$kriterialop[$btsloop];

                        // ambil kriteria dg bobot terbesar terlebih dahulu
                        // echo "Kriteria ".$idkrt."<br>";
                        if ($data_N_K[$B][$idkrt]>$data_N_K[$A][$idkrt]) {

                          // echo $idkrt." Lebih Besar ".$data_N_K[$B][$idkrt]." dari ".$data_N_K[$A][$idkrt]."<br>";
                          $kii[$ia]=$B;
                          $kii[$i]=$A;
                          $btsloop+=$bataslop;
                        }elseif ($data_N_K[$B][$idkrt]<$data_N_K[$A][$idkrt]) {

                          // echo $idkrt." Lebih Kecil ".$data_N_K[$B][$idkrt]." dari ".$data_N_K[$A][$idkrt]."<br>";
                          $kii[$ia]=$A;
                          $kii[$i]=$B;
                          $btsloop+=$bataslop;
                        }else{
                          if ($btsloop==($bataslop-1)) {
                            $cekkluarga=true;
                          }
                        }
                      }

                        // Cek Jumlah Keluarga
                        if ($cekkeluarga==true) {

                          if ($jml_keluarga[$B]>$jml_keluarga[$A]) {
                            // echo $B." Jumlah Keluarga Lebih Besar ".$jml_keluarga[$B]." dari ".$jml_keluarga[$A]."<br>";
                            $kii[$ia]=$B;
                            $kii[$i]=$A;

                          }elseif ($jml_keluarga[$B]<$jml_keluarga[$A]) {
                            // echo $B." Jumlah Keluarga Lebih Kecil ".$jml_keluarga[$B]." dari ".$jml_keluarga[$A]."<br>";
                            $kii[$ia]=$A;
                            $kii[$i]=$B;

                          }else{  
                            $cekkk=true;
                          } 
                        }

                        // Cek Lama No KK
                        if ($cekkk==true) {

                          if ($kk_terdaftar[$B]<$kk_terdaftar[$A]) {

                            // echo $B." KK Terdaftar Lebih Lama ".$kk_terdaftar[$B]." dari ".$kk_terdaftar[$A]."<br>";
                            $kii[$ia]=$B;
                            $kii[$i]=$A;

                          }elseif ($kk_terdaftar[$B]>$kk_terdaftar[$A]) {

                            // echo $B." KK Terdaftar Lebih kecil ".$kk_terdaftar[$B]." dari ".$kk_terdaftar[$A]."<br>";
                            $kii[$ia]=$A;
                            $kii[$i]=$B;

                          }else{
                            $cektime=true;
                          }
                        }

                         // Cek Time Input
                        if ($cektime==true) {

                          if ($time_input[$B]<$time_input[$A]) {

                            // echo $B." Alt Terdaftar lebih dahulu ".$time_input[$B]." dari ".$time_input[$A]."<br>";
                            $kii[$ia]=$B;
                            $kii[$i]=$A;

                          }elseif ($time_input[$B]>$time_input[$A]) {

                            // echo $B." Alt Terdaftar baru ".$time_input[$B]." dari ".$time_input[$A]."<br>";
                            $kii[$ia]=$A;
                            $kii[$i]=$B;

                          }
                        }

                      
                }
              }
              $jamPerBk=count($kii);
              for ($prb=0; $prb < $jamPerBk ; $prb++) { 
                $indk=$kiii[$prb];
                $keyi=$kii[$prb];
                $kunci[$indk]=$keyi;
              }
            }
          }
              $i=1;
              for ($jmlupdt=0; $jmlupdt < count($kunci); $jmlupdt++) { 
              // echo "alternatif ".$kunci[$jmlupdt]." nilai ".$nilai[$jmlupdt]."<br>";

                $id=$kunci[$jmlupdt];
                $nilaiup=$nilai[$jmlupdt];

                $query="INSERT INTO rangking VALUES('','$id','$nilaiup','$i','$id_laporan')";
                mysqli_query($koneksi,$query);
                $i=$i+1;
              }

                             
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
       window.location.replace('laporan.php');
       },1500);
       </script>
       ";
        }
        ?>


      <!-- End form content -->
  </section>
</div>
<!-- End Main Content -->

<?php include('../templetes/footer-admin.php'); ?>

<!-- Modal Tambah Data -->
              <div class="modal fade" id="modalLaporan" tabindex="-2" role="dialog" aria-labelledby="modalLaporanDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-success text-white" back>
                         <h5 class="modal-title modal-text" id="modalLaporanDataTitle">Form Simpan Hasil Seleksi</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama Laporan :</label>
                              <input type="text" class="form-control mt-1" name="nama" value="Laporan_Seleksi <?=date("d-M-Y"); ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="kuota" class="col-form-label">Kuota Penerima BANSOS :</label>
                              <input type="number" class="form-control mt-1" name="kuota" min="1" required>
                            </div>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" name="laporan" class="btn btn-primary">Save</button>
                         </div>
                       </form>
                     </div>
                    </form>
                  </div>
                </div>
              </div>

