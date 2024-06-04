    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-person-badge"></i><span>Data Karyawan</span><i class="bi bi-chevron-down ms-auto"></i> </a>
          <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="karyawan_baru.php"> <i class="bi bi-circle"></i><span>Data Karyawan Baru</span> </a>
            </li>
            <li>
              <a href="karyawan_lama.php"> <i class="bi bi-circle"></i><span>Data Karyawa Lama</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Components Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-people-fill"></i><span>Data Konsumen</span><i class="bi bi-chevron-down ms-auto"></i> </a>
          <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="data_konsumenBaru.php"> <i class="bi bi-circle"></i><span>Data Konsumen Baru</span> </a>
            </li>
            <li>
              <a href="data_konsumenLama.php"> <i class="bi bi-circle"></i><span>Data Konsumen Lama</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-pencil-square"></i><span>Input Data</span><i class="bi bi-chevron-down ms-auto"></i> </a>
          <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="input_produk.php"> <i class="bi bi-circle"></i><span>Data Produk</span> </a>
            </li>
            <li>
              <a href="input_bagian.php"> <i class="bi bi-circle"></i><span>Data Bagian</span> </a>
            </li>
            <li>
              <a href="input_harga.php"> <i class="bi bi-circle"></i><span>Input Harga</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Icons Nav -->

        <li class="nav-heading">Perhitungan Gaji Karyawan</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="gaji_karyawan.php">
            <i class="bi bi-calculator-fill"></i>
            <span>Gaji Karyawan</span>
          </a>
        </li>
        <!-- End Profile Page Nav -->
      </ul>
    </aside>
    <!-- End Sidebar-->