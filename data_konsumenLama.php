<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

if (isset($_POST['submit'])) {

    if (updateStatusKB($_POST) > 0) {
        echo "<script>alert('Berhasil ubah status konsumen!')</script>";
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
      <h1>DATA KONSUMEN ADITYA ROTAN</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Konsumen Lama</h5>

              <!-- <div class="row mb-3">
                  <label for="inputText" class="col-sm col-form-label"></label>
                  <div class="col-sm-2">
                    <a href="add_konsumen.php" class="btn btn-primary">Tambah Data</a>
                  </div>
              </div> -->

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Konsumen</th>
                    <th scope="col">Perusahaan</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col">Toggle</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    include 'koneksi.php';
                    $no = 1;
                    $data = mysqli_query($koneksi,"SELECT * FROM `konsumen` WHERE proses = '0'");
                    while($d = mysqli_fetch_array($data)){
                ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $d["nama_konsumen"]; ?></td>
                    <td><?= $d["perusahaan"]; ?></td>
                    <td><?= $d["telepon"]; ?></td>
                    <td><?= $d["alamat"]; ?></td>
                    <?php 
                      if ($d["proses"]=="1"){
                    ?>
                      <td>Sedang Diproses</td>
                    <?php
                      }else{
                    ?>
                      <td>Proses Selesai</td>
                    <?php
                      }
                    ?>
                    
                    <td>
                      <?php  
                        if($d['proses']=="1") {
                      ?>
                        <a href="nonaktif.php?id=<?php echo $d['id_konsumen']; ?>"><span class="badge bg-danger">Kontrak Selesai</span></a>
                        
                      <?php
                        }else {
                      ?>
                        <a href="aktif.php?id=<?php echo $d['id_konsumen']; ?>"><span class="badge bg-success">Kontrak Belum Selesai</span></a>
                      <?php
                        }
                      ?> 
                    </td>
                    <td>
                      <a href="update_konsumen.php?id=<?php echo $d['id_konsumen']; ?>&source=konsumen_lama" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
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