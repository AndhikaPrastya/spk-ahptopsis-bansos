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
  header("location: ../admin/index.php");
  exit;
}

    $page = "index";
    include('../templetes/topbar-operator.php');
    include('../templetes/menubar-operator.php');
?>
<style type="text/css">
  
</style>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <div class="section-body">
            <h1 class="section-title">Selamat Datang di SPK AHP-TOPSIS BANSOS</h1>
            <p class="section-lead">Desa Gebang, Kecamatan Gebang, Kabupaten Cirebon, Jawa Barat</p>
            <div class="card">
             
              <div class="card-body">
                
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>Flowchart</h4>
                      </div>
                      <div class="card-body">
                        <img src="../assets/img/flowchart.png" width="450px">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>Introduction</h4>
                      </div>
                      <div class="card-body">
                       <p align="justify">Sistem pendukung keputusan menggunakan metode <i>Analytical Hierarchy Process (AHP) - Technique for Others Reference by Similarity to Ideal</i> (TOPSIS) merupakan sistem yang dibangun untuk membantu dalam seleksi pemilihan penerima bantuan sosial di <b>Desa Gebang, Kecamatan Gebang, Kabupaten Cirebon, Jawa Barat</b>.</p>
                       <p><img src="../assets/img/logo.png" width="200px" style="float: left"></p>
                       <p align="justify">Sistem ini menggunakan 2 kombinasi metode <i>Decision Support System</i> yaitu metode AHP dan metode TOPSIS. Metode AHP pada sistem ini digunakan untuk menentukan nilai bobot kriteria dan nilai konsistensi kriteria terhadap kriteria lainnya pada penerima bantuan sosial dengan mengacu pada <b>Surat keputusan Menteri Sosial Republik Indonesia Nomor: 146/HUK/2013 tentang penetapan kriteria dan pendataan fakir miskin dan orang tidak mampu</b>, sedangkan TOPSIS digunakan untuk menentukan peringkat berdasarkan <i>preferensi</i> nilai penerima bantuan dengan bobot kriteria yang telah dicari oleh metode AHP sebelumnya. </p>
                       <p align="justify">Dengan adanya sistem ini diharapkan dapat membantu pihak terkait dalam menentukan penerima yang layak mendapatkan bantuan sosial.<p> 
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="card-footer bg-whitesmoke">
                This is card footer
              </div>
            </div>
          </div>
        </section>
      </div>

<?php include('../templetes/footer-operator.php'); ?>




      

