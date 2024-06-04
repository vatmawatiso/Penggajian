<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

if (isset($_POST['submit'])) {

    if (updateKonsumen($_POST) > 0) {
        echo "<script>alert('Berhasil ubah data konsumen!')</script>";
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
      <h1>Data Tables</h1>
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
              <h5 class="card-title">Edit Konsumen</h5>
              
              <?php
                include 'koneksi.php';
                $id = $_GET['id'];
                $source = $_GET['source'];
                echo $source;
                $data = "SELECT * FROM konsumen WHERE id_konsumen = '$id'";
                $query = mysqli_query($conn, $data);
                $d = mysqli_fetch_array($query);
              ?>

              <form action="" method="post">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="source" value="<?php echo $source; ?>" />
                    <input type="hidden" name="id_konsumen" value="<?php echo $d['id_konsumen'] ?>" />
                    <input type="text" class="form-control" name="nama_konsumen" value="<?php echo $d['nama_konsumen']; ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Perusahaan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="perusahaan" value="<?php echo $d['perusahaan']; ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="telepon" value="<?php echo $d['telepon']; ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat" value="<?php echo $d['alamat']; ?>" required>
                  </div>
                </div>

                <!--Tombol Save -->
                <div class="row mb-3">
                  <label for="inputText" class="col-sm col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
                  </div>
              </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->