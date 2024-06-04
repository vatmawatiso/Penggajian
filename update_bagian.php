<?php

session_start();
include_once("koneksi.php");
require 'function.php';

if (isset($_POST['submit'])) {

    if (updateBagian($_POST) > 0) {
        echo "<script>alert('Berhasil ubah data bagian!')</script>";
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
      <h1>Edit Bagian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-10">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bagian</h5>

              <?php
                include 'koneksi.php';
                $id = $_GET['id'];
                $data = "SELECT * FROM bagian WHERE id_bagian = '$id'";
                $query = mysqli_query($conn, $data);
                $d = mysqli_fetch_array($query);
              ?>

              <!-- Horizontal Form -->
              <form action="" method="post">
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id_bagian" value="<?php echo $d['id_bagian'] ?>" />
                    <input type="text" class="form-control" name="nama_bagian" value="<?= $d["nama_bagian"] ?>">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->