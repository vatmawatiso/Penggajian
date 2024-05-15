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
              <h5 class="card-title">Data Karyawan Aktif</h5>

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
                    $data = mysqli_query($koneksi,"SELECT * FROM `karyawan` WHERE status='1'");
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
                        <a href="nonaktif.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-warning">Tidak Aktif</a>
                        
                      <?php
                        }else {
                      ?>
                        <a href="aktif.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-warning">Aktif</a>
                      <?php
                        }
                      ?> 
                    </td>
                    <td>
                      <a href="update_karyawan.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-info"><i class="bi bi-pencil-square"></i> Edit</a>
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