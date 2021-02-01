 <nav class="navbar navbar-secondary navbar-expand-lg " id="menu">
        <div class="container">
          <ul class="navbar-nav">
            <li <?php  if($page == "index") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="index.php" class="nav-link"><i class="fas fa-home"></i></i><span>Home</span></a>
            </li>

            <li <?php  if($page == "kriteria") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="kriteria.php" class="nav-link"><i class="fas fa-chart-pie"></i><span>Kriteria</span></a>
            </li>

            <li <?php  if($page == "alternatif") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="alternatif.php" class="nav-link"> <i class="fas fa-table"></i><span>Alternatif</span></a>
            </li>

            <li <?php  if($page == "analisis") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="analisis.php" class="nav-link"> <i class="fas fa-pencil-alt"></i><span>Penilaian Alternatif</span></a>
            </li>

            <li <?php  if($page == "hasil") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="output_topsis.php" class="nav-link"><i class="fas fa-chart-bar"></i><span>Hasil Perhitungan</span></a>
            </li>

            <li <?php  if($page == "rangking") {
              echo "class='nav-item active'";
            }else{
              echo "class='nav-item'";
            } ?>
            >
              <a href="laporan.php" class="nav-link"> <i class="fas fa-book"></i></i><span>Laporan Seleksi</span></a>
            </li>
          </ul>
        </div>
 </nav>