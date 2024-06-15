<?php

session_start();
include_once("koneksi.php");
require 'function.php';

$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
  $result = updateBagian($_POST);

  if ($result['success']) {
      $alert_message = 'Berhasil mengubah data bagian!';
      $alert_class = 'alert-success';
  } else {
      $alert_message = $result['message'];
      $alert_class = 'alert-danger';
  }

  echo "<script>
          setTimeout(function() {
              window.location.href = 'input_bagian.php';
          }, 3000);
        </script>";
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
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <?php if ($alert_message): ?>
              <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                  <?php echo $alert_message; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>

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