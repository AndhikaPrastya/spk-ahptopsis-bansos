<?php

function query($query){
	include('config.php');

	$result=mysqli_query($koneksi,$query);
	$rows=[];
	while($row=mysqli_fetch_assoc($result)){
		$rows[]=$row;
	}return $rows;
}


function tambahDataKriteria($data){
 	include('config.php');


 	$kode_kriteria = htmlspecialchars($data["kode_kriteria"]);
 	$nama = htmlspecialchars($data["nama"]);

	// Pembatas 15 kriteria
 	$data_kriteria =mysqli_query($koneksi, "SELECT * FROM kriteria");
	// var_dump($jmlkrt); die;

 	if (mysqli_num_rows($data_kriteria)>14) {
 		echo "<script>
 				alert('Maksimal 15 Kriteria!')
 			  </script>";
 			  return false;
 	}

 	//cek nama dan kode ada atau belum
 	$result =mysqli_query($koneksi, "SELECT * FROM kriteria WHERE kode_kriteria = '$kode_kriteria' OR nama = '$nama'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('Data kriteria sudah ada!')
 			  </script>";
 			  return false;
 	}
 	

 	$query = "INSERT INTO kriteria VAlUES ('','$kode_kriteria','$nama')";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function editDataKriteria($data){
 	include('config.php');

 	$id = $data["id"];
 	$kode_kriteria = htmlspecialchars($data["kode_kriteria"]);
	$nama = htmlspecialchars($data["nama"]);

	//cek nama dan kode ada atau belum
 	$result =mysqli_query($koneksi, "SELECT * FROM kriteria WHERE nama = '$nama'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('Data kriteria sudah ada!')
 			  </script>";
 			  return false;
 	}

 	$query = "UPDATE kriteria SET 
 				   kode_kriteria='$kode_kriteria', nama='$nama' WHERE id='$id'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function hapusDataKriteria($data) {
	include('config.php');

	// hapus record dari tabel kriteria
	$id=htmlspecialchars($_POST["id"]);
	$query 	= "DELETE FROM kriteria WHERE id=$id";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel pv_kriteria
	$query1 	= "DELETE FROM pv_kriteria WHERE id_kriteria=$id";
	mysqli_query($koneksi, $query1);

	// hapus record dari tabel perbandingan kriteria
	$query2 	= "DELETE FROM perbandingan_kriteria WHERE kriteria1=$id OR kriteria2=$id";
	mysqli_query($koneksi, $query2);

	// hapus record dari tabel parameter
	$query3 	= "DELETE FROM parameter WHERE id_kriteria=$id";
	mysqli_query($koneksi, $query3);

	// hapus record dari tabel nilai_analisis
	$query4 	= "DELETE FROM nilai_analisis WHERE id_kriteria=$id";
	mysqli_query($koneksi, $query4);

	return mysqli_affected_rows($koneksi);

}

function tambahDataParameter($data){
 	include('config.php');

 	$id_kriteria = $data["id_kriteria"];
 	$nama_parameter = htmlspecialchars($data["nama_parameter"]);
 	$nilai_parameter = htmlspecialchars($data["nilai_parameter"]);

 	//cek nama sudah ada atau belum
 	$result =mysqli_query($koneksi, "SELECT * FROM parameter WHERE nama_parameter = '$nama_parameter'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('Data parameter sudah ada!')
 			  </script>";
 			  return false;
 	}

 	$query = "INSERT INTO parameter VAlUES ('','$id_kriteria','$nama_parameter','$nilai_parameter')";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function editDataParameter($data){
 	include('config.php');

 	$id_parameter = $data["id_parameter"];
 	$id_kriteria = $data["id_kriteria"];
 	$nama_parameter = htmlspecialchars($data["nama_parameter"]);
 	$nilai_parameter = $data["nilai_parameter"];

 	// //cek nama sudah ada atau belum
 	$result =mysqli_query($koneksi, "SELECT * FROM parameter WHERE nama_parameter = '$nama_parameter' AND nilai_parameter='$nilai_parameter'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('Data parameter sudah ada!')
 			  </script>";
 			  return false;
 	}

 	$query = "UPDATE parameter SET 
 				     id_kriteria='$id_kriteria', 
 				     nama_parameter='$nama_parameter', 
 				     nilai_parameter='$nilai_parameter' WHERE id_parameter='$id_parameter'";


 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function hapusDataParameter($data) {
	include('config.php');

	// hapus record dari tabel parameter
	$id_parameter=$data["id_parameter"];
	$query 	= "DELETE FROM parameter WHERE id_parameter=$id_parameter";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahDataAlternatif($data){
 	include('config.php');
 
 	$id = $data["id"];
 	$no_kk = htmlspecialchars($data["no_kk"]);
 	$nama = htmlspecialchars($data["nama"]);
 	$alamat = htmlspecialchars($data["alamat"]);
 	$time_input = $data["time_input"];
 	$id_user = $data["id_user"];
 	$jml_keluarga = $data["jml_keluarga"];

 	// ambil tanggal kk_terdaftar bertempat tinggal dari no KK
 	$no_kk2 = $no_kk;
 	$tgl = substr_replace(substr_replace($no_kk2,"",0,6),"",-8);
 	$bln = substr_replace(substr_replace($no_kk2,"",0,8),"",-6);
 	$thn = substr_replace(substr_replace($no_kk2,"",0,10),"",-4);

 	$now = date('Y');
 	$year = substr_replace(substr_replace($now,"",0,2),"",2); 

 	if ($thn > $year) {
 		$join = $bln.'/'.$tgl.'/19'.$thn;
 	} else {
 		$join = $bln.'/'.$tgl.'/20'.$thn;
 	}

 	$kk_terdaftar = strtotime($join);

 	//cek no KK ada atau belum
 	$result =mysqli_query($koneksi, "SELECT no_kk FROM alternatif WHERE no_kk = '$no_kk' AND id_status=1");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('No KK sudah terdaftar!')
 			  </script>";
 			  return false;
 	}

 	$query = "INSERT INTO alternatif VAlUES ('','$nama','$no_kk','$alamat','$jml_keluarga','$kk_terdaftar','$time_input','',1,'$id_user')";
 	mysqli_query($koneksi,$query);

	//tambah record juga ke dalam hasil
 	// $query1 = "INSERT INTO hasil (id_alternatif) VAlUES (LAST_INSERT_ID())";
 	// mysqli_query($koneksi,$query1);

 	//tambah record juga ke dalam hasil
 	$result = mysqli_query($koneksi, "SELECT * FROM alternatif group by id DESC limit 0,1 ");
 	$krt = mysqli_fetch_assoc($result);
 	$id=$krt['id'];
 	$jmlkr=query("SELECT*FROM kriteria");
 	foreach ($jmlkr as $key) {
 		$kriteria=$key['id'];
 		$insert="INSERT INTO nilai_analisis VALUES('','$id','','$kriteria')";
 		mysqli_query($koneksi,$insert);
 	}
 	return mysqli_affected_rows($koneksi);

}

function editDataAlternatif($data){
 	include('config.php');

 	$id = $data["id"];
 	$no_kk2 = htmlspecialchars($data["no_kk2"]);
	$nama2 = htmlspecialchars($data["nama2"]);
	$alamat2 = htmlspecialchars($data["alamat2"]);
	$jml_keluarga2 = htmlspecialchars($data["jml_keluarga2"]);
	$kk_terdaftar2 = htmlspecialchars($data["kk_terdaftar2"]);
	$id_user2 = htmlspecialchars($data["id_user2"]);

 	$no_kk = htmlspecialchars($data["no_kk"]);
	$nama = htmlspecialchars($data["nama"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$jml_keluarga = htmlspecialchars($data["jml_keluarga"]);
	$id_user = htmlspecialchars($data["id_user"]);
	$time_input = $data['time_input'];
 	$row_edit = $id;
 	$id_status = $data['id_status'];

 	$no_kkx = $no_kk;
 	$tgl = substr_replace(substr_replace($no_kkx,"",0,6),"",-8);
 	$bln = substr_replace(substr_replace($no_kkx,"",0,8),"",-6);
 	$thn = substr_replace(substr_replace($no_kkx,"",0,10),"",-4);

 	$now = date('Y');
 	$year = substr_replace(substr_replace($now,"",0,2),"",2); 

 	if ($thn > $year) {
 		$join = $bln.'/'.$tgl.'/19'.$thn;
 	} else {
 		$join = $bln.'/'.$tgl.'/20'.$thn;
 	}

 	$kk_terdaftar = strtotime($join);

	//cek no KK ada atau belum
 	$result =mysqli_query($koneksi, "SELECT no_kk FROM alternatif 
 									WHERE no_kk = '$no_kk' AND nama='$nama' AND alamat='$alamat' AND jml_keluarga='$jml_keluarga'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('No KK sudah terdaftar!')
 			  </script>";
 			  return false;
 	}

 	$query = "UPDATE alternatif SET 
 				   nama='$nama', no_kk='$no_kk', alamat='$alamat',jml_keluarga='$jml_keluarga',kk_terdaftar='$kk_terdaftar', id_status=1, id_user='$id_user' WHERE id='$id'";
 	mysqli_query($koneksi,$query);

 	$query2 = "INSERT INTO alternatif VAlUES ('','$nama2','$no_kk2','$alamat2','$jml_keluarga2','$kk_terdaftar2','$time_input','$row_edit',2,'$id_user2')";
 	mysqli_query($koneksi,$query2);
 	return mysqli_affected_rows($koneksi);
}

function editDataAlternatif2($data){
 	include('config.php');

	$id = $data["id"];

	$result =mysqli_query($koneksi, "SELECT no_kk FROM alternatif WHERE no_kk = '$no_kk' AND id_status=1");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('No KK sudah terdaftar!')
 			  </script>";
 			  return false;
 	}

 	$query = "UPDATE alternatif SET id_status = 1 WHERE id='$id'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function hapusDataAlternatif($data) {
	include('config.php');

	// hapus record dari tabel kriteria
	$id=$data["id"];
	$query 	= "DELETE FROM alternatif WHERE id=$id";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel nilai_analisis
	$query2 	= "DELETE FROM nilai_analisis WHERE id_alternatif=$id";
	mysqli_query($koneksi, $query2);

	// hapus record dari tabel hasil
	$query3 	= "DELETE FROM hasil WHERE id_alternatif=$id";
	mysqli_query($koneksi, $query3);

	// hapus record dari tabel rangking
	$query4 	= "DELETE FROM rangking WHERE id_alternatif=$id";
	mysqli_query($koneksi, $query4);

	return mysqli_affected_rows($koneksi);
}


function hapusDataAlternatif2($data) {
	include('config.php');

	$id=$data["id"];

	$query 	= "UPDATE alternatif SET id_status = 2 WHERE id='$id'";

	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}


function register($data){
 	include('config.php');

 	$nama = htmlspecialchars($data["nama"]);
 	$email = htmlspecialchars($data["email"]);
 	$username = htmlspecialchars($data["username"]);
 	$id_role = htmlspecialchars($data["id_role"]);
 	$password = mysqli_real_escape_string($koneksi, $data["password"]);
 	$password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
 	$time_input = $data["time_input"];
 	$id_status = htmlspecialchars($data["id_status"]);


 	//cek username ada atau belum
 	$result =mysqli_query($koneksi, "SELECT username, email FROM user WHERE username = '$username' OR email = '$email'");

 	if ( mysqli_fetch_assoc($result)) {
 		echo "<script>
 				alert('Username atau email sudah terdaftar!')
 			  </script>";
 			  return false;
 	}

 	// cek password
 	if ($password !== $password2) {
 		echo "<script>
 			   alert('Konfirmasi password tidak sesuai!');
 			  </script>";
 		return false;
 	}
 		//enkripsi password
 	$password = password_hash($password, PASSWORD_DEFAULT);
 	$query = "INSERT INTO USER VAlUES ('','$nama','$email','$username','$password','$id_role','$time_input',0,'$id_status')";

 		mysqli_query($koneksi,$query);
 		return mysqli_affected_rows($koneksi);
}


function editDataRole($data){
	include('config.php');

	$id = $data["id"];
	$id_role = $data["role"];

 	$query = "UPDATE user SET id_role='$id_role' WHERE id='$id'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);

}

function editDataStatus($data){
	include('config.php');

	$id = $data["id"];

 	$query = "UPDATE user SET id_status = 1 WHERE id='$id'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);

}

function hapusDataUser1($data) {
	include('config.php');

	// hapus record dari tabel kriteria
	$id=$data["id"];
	$query 	= "DELETE FROM user WHERE id=$id";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function hapusDataUser2($data) {
	include('config.php');

	$id = $data["id"];

 	$query = "UPDATE user SET id_status = 2 WHERE id='$id'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);
}

function hapusDataLaporan($data) {
	include('config.php');

	// hapus record dari tabel laporan
	$id_laporan=htmlspecialchars($_POST["id_laporan"]);
	$query 	= "DELETE FROM laporan WHERE id_laporan=$id_laporan";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel hasil
	$query1 	= "DELETE FROM hasil WHERE id_laporan=$id_laporan";
	mysqli_query($koneksi, $query1);

	// hapus record dari tabel Rangking
	$query2 	= "DELETE FROM rangking WHERE id_laporan=$id_laporan";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function editDataLaporan($data){
	include('config.php');

	$id_laporan = $data["id_laporan"];
	$nama = $data["nama"];
	$kuota = $data["kuota"];

 	$query = "UPDATE laporan SET nama='$nama',kuota=$kuota WHERE id_laporan='$id_laporan'";

 	mysqli_query($koneksi,$query);
 	return mysqli_affected_rows($koneksi);

}

function editDataProfile($data){
	include('config.php');

	$id = $data["id"];
	$nama2 = htmlspecialchars($data["nama2"]);
 	$email2 = htmlspecialchars($data["email2"]);
 	$username2 = htmlspecialchars($data["username2"]);
	$nama = htmlspecialchars($data["nama"]);
 	$email = htmlspecialchars($data["email"]);
 	$username = htmlspecialchars($data["username"]);
 	$password = $data["password"];
 	$id_role = $data['id_role'];
 	$time_input = $data['time_input'];
 	$row_edit = $id;
 	$id_status = $data['id_status'];
 	

 	$query = "UPDATE user SET nama='$nama', email='$email', username='$username', id_role=$id_role, id_status=$id_status
 			  WHERE id='$id'";
 	mysqli_query($koneksi,$query);

 	$query2 = "INSERT INTO user VAlUES ('','$nama2','$email2','$username2','$password',1,'$time_input','$row_edit',2)";
 	mysqli_query($koneksi,$query2);
 	return mysqli_affected_rows($koneksi);
}


// mencari ID kriteria
// berdasarkan urutan ke berapa (C1, C2, C3)
function getKriteriaID($no_urut) {
	include('config.php');
	$query  = "SELECT id FROM kriteria ORDER BY id";
	$result = mysqli_query($koneksi, $query);

	while ($row = mysqli_fetch_array($result)) {
		$listID[] = $row['id'];
	}

	return $listID[($no_urut)];
}

// mencari nama kriteria
function getKriteriaNama($no_urut) {
	include('config.php');
	$query  = "SELECT nama FROM kriteria ORDER BY id";
	$result = mysqli_query($koneksi, $query);

	while ($row = mysqli_fetch_array($result)) {
		$nama[] = $row['nama'];
	}

	return $nama[($no_urut)];
}

// mencari bobot kriteria
function getBobotKriteria($id_kriteria) {
	include('config.php');
	$query = "SELECT nilai FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$pv = $row['nilai'];
	}

	return $pv;
}

// mencari jumlah kriteria
function getJumlahKriteria() {
	include('config.php');
	$query  = "SELECT count(*) FROM kriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$jmlData = $row[0];
	}

	return $jmlData;
}

// memasukkan nilai priority vektor kriteria
function inputKriteriaPV ($id_kriteria,$pv) {
	include ('config.php');

	$query = "SELECT * FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO pv_kriteria (id_kriteria, nilai) VALUES ($id_kriteria, $pv)";
	} else {
		$query = "UPDATE pv_kriteria SET nilai=$pv WHERE id_kriteria=$id_kriteria";
	}


	$result = mysqli_query($koneksi, $query);
	if(!$result) {
		echo "Gagal memasukkan / update nilai priority vector kriteria";
		exit();
	}

}

// memasukkan bobot nilai perbandingan kriteria
function inputDataPerbandinganKriteria($kriteria1,$kriteria2,$nilai) {
	include('config.php');

	$id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);

	$query  = "SELECT * FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO perbandingan_kriteria (kriteria1,kriteria2,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)";
	} else {
		$query = "UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria1=$id_kriteria1 AND kriteria2=$id_kriteria2";
	}

	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Gagal memasukkan data perbandingan";
		exit();
	}

}

// mencari nilai bobot perbandingan kriteria
function getNilaiPerbandinganKriteria($kriteria1,$kriteria2) {
	include('config.php');

	$id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);

	$query  = "SELECT nilai FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	if (mysqli_num_rows($result)==0) {
		$nilai = 1;
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$nilai = $row['nilai'];
		}
	}

	return $nilai;
}

// menampilkan nilai IR
function getNilaiIR($jmlKriteria) {
	include('config.php');
	$query  = "SELECT nilai FROM ir WHERE jumlah=$jmlKriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$nilaiIR = $row['nilai'];
	}

	return $nilaiIR;
}

// mencari Principe Eigen Vector (λ maks)
function getEigenVector($matrik_a,$matrik_b,$n) {
	$eigenvektor = 0;
	for ($i=0; $i <= ($n-1) ; $i++) {
		$eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
	}

	return $eigenvektor;
}

// mencari Cons Index
function getConsIndex($matrik_a,$matrik_b,$n) {
	$eigenvektor = getEigenVector($matrik_a,$matrik_b,$n);
	$consindex = ($eigenvektor - $n)/($n-1);

	return $consindex;
}

// Mencari Consistency Ratio
function getConsRatio($matrik_a,$matrik_b,$n) {
	$consindex = getConsIndex($matrik_a,$matrik_b,$n);
	$consratio = $consindex / getNilaiIR($n);

	return $consratio;
}

// menampilkan tabel perbandingan bobot
function showTabelPerbandingan($jenis,$kriteria) {
	include('config.php');

	$n = getJumlahKriteria();

	$query = "SELECT nama FROM $kriteria ORDER BY id";
	$result	= mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Error koneksi database!!!";
		exit();
	}
	// buat list nama pilihan
	while ($row = mysqli_fetch_array($result)) {
		$pilihan[] = $row['nama'];
	}
	// tampilkan tabel
	?>
	<form class="ui form" action="proses_ahp.php" method="post">
	<div class="card-body">
     <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                	<thead class="table-info">
                		<tr>
                			<th class="text-sm-center" colspan="2" >Pilih yang lebih penting</th>
                			<th class="text-sm-center" >Nilai perbandingan</th>
                		</tr>
                	</thead>
					<tbody>

					<!-- inisialisasi -->
					<?php
						$urut = 0;
						for ($x=0; $x <= ($n - 2); $x++) {
							for ($y=($x+1); $y <= ($n - 1) ; $y++) {
								$urut++;
					?>
						<tr>
							<td>
								<div class="field">
									<div class="ui radio checkbox" >
										<input name="pilih<?php echo $urut?>" value="1" checked="" class="hidden align-middle" type="radio">
										<label><?php echo $pilihan[$x]; ?></label>
									</div>
								</div>
							</td>
							<td>
								<div class="field">
									<div class="ui radio checkbox">
										<input name="pilih<?php echo $urut?>" value="2" class="hidden align-middle" type="radio">
										<label><?php echo $pilihan[$y]; ?></label>
									</div>
								</div>
							</td>
							<td>
								<div class="field">

									<?php
										$nilai = getNilaiPerbandinganKriteria($x,$y);
									?>

									<div class="">
										<select class="form-control" name="bobot<?php echo $urut?>" 
												id="exampleFormControlSelect1">
											<option value="1">1 : Sama Penting</option>
											<option value="2">2 : Nilai Tengah</option>
											<option value="3">3 : Sedikit Lebih Penting</option>
											<option value="4">4 : Nilai Tengah</option>
											<option value="5">5 : Lebih Penting</option>
											<option value="6">6 : Nilai Tengah</option>
											<option value="7">7 : Sangat Penting</option>
											<option value="8">8 : Nilai Tengah</option>
											<option value="9">9 : Mutlak Lebih Penting</option>
										</select>
									</div>

								</div>
							</td>
						</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
		<input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
		<input class="btn btn-success float-right" type="submit" name="submit" value="SUBMIT" >
	</form>
	<?php
}


function ubahpass($data){
	global $koneksi;

	$id              = $data["id"];
	$password_old    = htmlspecialchars($data["password_old"]);
	$password1       = htmlspecialchars($data["password1"]);
	$password2       = htmlspecialchars($data["password2"]);
	
	$result = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");

	if( mysqli_num_rows($result) == 1 ) {
	    $row = mysqli_fetch_assoc($result);
	    // validasi pass lama
	    if (password_verify($password_old, $row["password"]) ) {
	    	// cek kesamaan password
	    	if ($password1 !== $password2) {
	    		echo "<script>
		    		  alert('Konfirmasi password tidak sesuai!');
		    		  </script>";
	    		return false;
	    	}

	    	$password = password_hash($password1, PASSWORD_DEFAULT);
	    	mysqli_query($koneksi, "UPDATE user SET password ='$password' WHERE id = $id");
	    	return mysqli_affected_rows($koneksi);

	   	} else {
	   		echo "<script>
		    	  alert('Password lama salah!');
		    	  </script>";
	        return false;
	   	}
	}
}
