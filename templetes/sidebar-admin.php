 <!-- Begin Sidebar -->
      <div class="main-sidebar" id="menu">
        <aside id="sidebar-wrapper">

          <div class="sidebar-brand">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

              <style type="text/css">
                .size {
                  width: 50px;
                }
              </style>

              <div>
                <img class="size" src="../assets/img/logo.png">
              </div>
              <div class="sidebar-brand-text mx-3 text-white">AHP-TOPSIS <sup>BANSOS</sup></div>
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">
              
              <style type="text/css">
                .size2 {
                  width: 50px;
                }
              </style>

              <div>
                <img class="size2" src="../assets/img/logo.png">
              </div>
            </a>
          </div>
          <ul class="sidebar-menu">
              <!-- --------------------------- -->
              <li class="menu-header">Dashboard</li>
                <li <?php if($page == "index") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="index.php"><i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span></a></li>

              <!-- --------------------------- -->
              <li class="menu-header">AHP-TOPSIS</li>
                <li <?php if($page == "kriteria") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="kriteria.php"> <i class="far fa-file-alt"></i> <span>Menu Kriteria</span></a></li>

                <li <?php if($page == "parameter") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="parameter_kriteria.php"> <i class="fas fa-chart-pie"></i> <span>Parameter Kriteria</span></a></li>

                <li <?php if($page == "alternatif") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="alternatif.php"> <i class="fas fa-table"></i> <span>Menu Alternatif</span></a></li>

                 <li <?php if($page == "analisis") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="analisis.php"> <i class="fas fa-pencil-alt"></i> <span>Penilaian Alternatif</span></a></li>

                <li <?php if($page == "hasil") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                >
                <a class="nav-link" href="output_topsis.php"> <i class="fas fa-chart-bar"></i> <span>Hasil Perhitungan</span></a></li>

                <li <?php if($page == "rangking") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                > 
                <a class="nav-link" href="laporan.php"> <i class="fas fa-book"></i> <span>Laporan Seleksi</span></a></li>

               <li class="menu-header">USER</li>
                <li <?php if($page == "profil") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                > 
                <a class="nav-link" href="profil.php"> <i class="fas fa-user"></i> <span>My Profile</span></a></li>
                
                <li <?php if($page == "user") { 
                          echo "class='active'"; 
                        } else {
                          echo "class='n' ";
                        } ?>
                > 
                <a class="nav-link" href="user.php"> <i class="fas fa-user-cog"></i> <span>Menu User</span></a></li>

               <!-- --------------------------- -->
               <li class="menu-header">SYSTEM</li>
                <li><a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal"> <i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>

        </aside>
      </div>
  <!-- End Sidebar -->

  <style type="text/css">
      .latar-belakang {
        background-image: url('../assets/img/foto6.jpg');
        background-repeat: no-repeat;
        background-size: cover;
      }
      .text-judul {
        color: #ffffff;
      }
    </style>