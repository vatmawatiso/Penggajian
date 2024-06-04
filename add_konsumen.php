<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

if (isset($_POST['tambahKonsumen'])) {

    if (insertKonsumen($_POST) > 0) {
        echo "<script>alert('Berhasil menambahkan data konsumen!')</script>";
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
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah Konsumen</h5>
              
              <form action="" method="post">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nama Konsumen</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_konsumen" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Perusahaan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="perusahaan" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nomer Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="telepon" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat" required>
                  </div>
                </div>

                <!--Tombol Save -->
                <div class="row mb-3">
                  <label for="inputText" class="col-sm col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" name="tambahKonsumen" class="btn btn-primary">Simpan Data</button>
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