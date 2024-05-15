<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

if (isset($_POST['submit'])) {

    if (updateStatusKB($_POST) > 0) {
        echo "<script>alert('Berhasil ubah status karyawan!')</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!-- ======= Header ======= -->
<?php include "template/header.php"; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include "template/sidebar.php"; ?>
<!-- End Sidebar -->

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
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-menu-button-wide"></i><span>Data Karyawan</span><i class="bi bi-chevron-down ms-auto"></i> </a>
          <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="karyawan_baru.php"> <i class="bi bi-circle"></i><span>Data Karyawan Aktif</span> </a>
            </li>
            <li>
              <a href="karyawan_lama.php"> <i class="bi bi-circle"></i><span>Data Karyawa Tidak Aktif</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Components Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-layout-text-window-reverse"></i><span>Data Konsumen</span><i class="bi bi-chevron-down ms-auto"></i> </a>
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

        <li class="nav-heading">Perhitungan Gaji Karyawan</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="gaji_karyawan.php">
            <i class="bi bi-person"></i>
            <span>Gaji Karyawan</span>
          </a>
        </li>
        <!-- End Profile Page Nav -->
      </ul>
    </aside>
    <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Karyawan Aditya Rotan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Karyawan Tidak Aktif</h5>

              <div class="row mb-3">
                  <label for="inputText" class="col-sm col-form-label"></label>
                  <div class="col-sm-2">
                    <a href="add_karyawan.php" class="btn btn-primary">Tambah Data</a>
                  </div>
              </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Tahun Masuk</th>
                    <th scope="col">Status</th>
                    <th scope="col">Toggle</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    include 'koneksi.php';
                    $no = 1;
                    $data = mysqli_query($koneksi,"SELECT * FROM `karyawan` WHERE status = 'Tidak Aktif'");
                    while($d = mysqli_fetch_array($data)){
                ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $d["nama_karyawan"]; ?></td>
                    <td><?= $d["NIK"]; ?></td>
                    <td><?= $d["jenis_kelamin"]; ?></td>
                    <td><?= $d["nomer_hp"]; ?></td>
                    <td><?= $d["alamat"]; ?></td>
                    <td><?= $d["jabatan"]; ?></td>
                    <td><?= $d["thn_masuk"]; ?></td>
                    <?php 
                      if ($d["status"]=="1"){
                    ?>
                      <td>Aktif</td>
                    <?php
                      }else{
                    ?>
                      <td>Tidak Aktif</td>
                    <?php
                      }
                    ?>
                    
                      <td>
                        <?php  
                          if($d['status']=="1") {
                        ?>
                          <a href="nonaktif.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-success">Tidak Aktif</a>
                        <?php
                          }else {
                        ?>
                          <a href="aktif.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-success">Aktif</a>
                        <?php
                          }
                        ?> 
                      </td>
                    <td>
                      <a href="update_karyawan.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-info"><i class="bi bi-pencil-square"></i> Edit</a>
                      <a href="delete_karyawan.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</a>
                    </td>

                  </tr>
                <?php 
                   }
                ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->