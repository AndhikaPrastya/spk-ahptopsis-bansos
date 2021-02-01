<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
require_once "config.php";

date_default_timezone_set('Asia/Jakarta');
$id_laporan=$_GET['id_laporan'];
$hasil=query("SELECT * FROM rangking where id_laporan='$id_laporan'")[0];

$alt=mysqli_query($koneksi, "SELECT * FROM rangking where id_laporan='$id_laporan'");
$jml_alt=mysqli_num_rows($alt);

$laporan=query("SELECT * FROM laporan WHERE id_laporan='$id_laporan'")[0];
$jml_unrekom=$jml_alt-$laporan['kuota'];

$rangking=mysqli_query($koneksi,"SELECT a.nilai, a.rank, b.nama, b.no_kk, b.alamat, 
                                        b.time_input, b.jml_keluarga, b.kk_terdaftar, c.kuota FROM rangking a JOIN alternatif b 
                                        ON a.id_alternatif = b.id JOIN laporan c ON a.id_laporan = c.id_laporan 
                                        WHERE a.id_laporan = $id_laporan AND a.rank <= c.kuota ");
  

$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$data = '
<!DOCTYPE html>
<html>
<head>
	<title>Rangking Penilaian</title>
</head>
<body>
	<table margin="auto">
      <tr>
         <td width="20%"><img src="assets/img/logo.png" alt="logo-umc" width="100px" height="100px"></td>
         <td width="85%">
         <center>
            <font size="5">PUSAT KESEJAHTERAAN SOSIAL</font><br>
            <font size="5"><b>DESA GEBANG</b></font><br>
            <font size="5">KECAMATAN GEBANG KABUPATEN CIREBON</font><br>
            <font size="3">Alamat : Jl.Raya Pangeran Sutajaya No.67 Telpon : 662109 </font><br>
            <font size="3"><i>Website : pemdes-gebang.com Email : pemdes.gebang@gmail.com</i></font><br>
         </center>
         </td>
         <td width="20%"><img src="assets/img/logo-blank.png" alt="logo-umc" width="100px" height="100px"></td>
      </tr>
      <tr>
         <td colspan="3"><hr></td>
      </tr>
   </table>

   <table margin="auto">
         <tr>
            <td width="30%">
               <center>
                     <font size="5">Data Penerima Bantuan Sosial Yang Direkomendasikan</font><br>
               </center>
            </td>
         </tr>
   </table>
   <br>

   <table margin="100%">
         <tr>
            <td><font size="3">Nama Laporan </font></td>
            <td><font size="3">:</font></td>
            <td><font size="3">'.$laporan["nama"].'</font></td>
         </tr>
         <tr>
            <td><font size="3">Jumlah Semua KK </font></td>
            <td><font size="3">:</font></td>
            <td><font size="3">'.$jml_alt.' KK</font></td>
         </tr>
         <tr>
            <td><font size="3">Jumlah Penerima BANSOS </font></td>
            <td><font size="3">:</font></td>
            <td><font size="3">'.$laporan["kuota"].' KK</font></td>
         </tr>
   </table>

	<table border="1" cellpadding="10" cellspacing="0" autosize="1" width="100%">
            <tr>
               <th><font size="3">No</font></th>
               <th><font size="3">No.KK</font></th>
               <th><font size="3">Nama</font></th>
               <th><font size="3">Alamat</font></th>
               <th><font size="3">Nilai</font></th>
               <th><font size="3">Keterangan</font></th>
            </tr>';

            $i = 1;
            $ket = "Rekomendasi"; 
            foreach ($rangking as $key) {
            	$data .= '<tr>
                  				<td style="text-align:center;"><font size="3">'. $i++ . '</font></td>
                  				<td style="text-align:center;"><font size="3">'. $key["no_kk"] .'</font></td>
                  				<td><font size="3">'. $key["nama"] .'</font></td>
                  				<td><font size="3">'. $key["alamat"] .'</font></td>
                  				<td style="text-align:right;"><font size="3">'. $key["nilai"] .'</font></td>
                              <td><font size="3">'. $ket .'</font></td>
            			   </tr>';
            }

$data .= '</table>

</body>
</html>
';
$mpdf->Image('assets/img/logo.png',0,0,210,297,'png','',true,false);
$mpdf->WriteHTML($data);
$mpdf->Output();
?>

