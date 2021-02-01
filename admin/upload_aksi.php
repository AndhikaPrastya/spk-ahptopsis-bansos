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

// menghubungkan dengan koneksi
include '../config.php';
include '../functions.php';
// menghubungkan dengan library excel reader
include "../excel_reader2/excel_reader2.php";

$idx=$_SESSION['id'];
$user=query("SELECT id FROM user WHERE id='$id'")[0];
?>
 
<?php
// upload file xls
$target = basename($_FILES['filealternatif']['name']) ;
move_uploaded_file($_FILES['filealternatif']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['filealternatif']['name'],0777);
 
// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['filealternatif']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// var_dump($jumlah_baris); die;
 
// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=6; $i<=$jumlah_baris; $i++){
 
	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$nama     		= $data->val($i, 2);
	$no_kk   		= $data->val($i, 3);
	$alamat  		= $data->val($i, 4);
	$jml_keluarga  	= $data->val($i, 5);
	$time_input  	= date("Y-m-d H:i:s");
 	$id_user 		= $idx;


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

 
	if($nama != "" && $no_kk != "" && $alamat != ""){
		// input data ke database (table data warga)
		mysqli_query($koneksi,"INSERT into alternatif 
							   VALUES('','$nama','$no_kk','$alamat','$jml_keluarga','$kk_terdaftar','$time_input','',1,'$id_user')");
		mysqli_query($koneksi,"INSERT INTO hasil (id_alternatif) VAlUES (LAST_INSERT_ID())");
		$result = mysqli_query($koneksi, "SELECT * FROM alternatif group by id DESC limit 0,1 ");
		$krt = mysqli_fetch_assoc($result);
		$id=$krt['id'];
		$jmlkr=query("SELECT*FROM kriteria");
		foreach ($jmlkr as $key) {
			$kriteria=$key['id'];
			$insert="INSERT INTO nilai_analisis VALUES('','$id','','$kriteria')";
			mysqli_query($koneksi,$insert);
		$berhasil++;
	}
}
}
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['filealternatif']['name']);
 
// alihkan halaman ke index.php
header("location:alternatif.php?berhasil=$berhasil");
?>