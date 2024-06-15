<?php

session_start();
include_once("koneksi.php");
require 'function.php';

$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
  $result = updateProduk($_POST);

  if ($result['success']) {
      $alert_message = 'Berhasil mengubah data produk!';
      $alert_class = 'alert-success';
  } else {
      $alert_message = $result['message'];
      $alert_class = 'alert-danger';
  }

  echo "<script>
          setTimeout(function() {
              window.location.href = 'input_produk.php';
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
      <h1>Edit Produk</h1>
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
              <h5 class="card-title">Produk</h5>

              <?php
                include 'koneksi.php';
                $id = $_GET['id'];
                $data = "SELECT * FROM produk WHERE id_produk = '$id'";
                $query = mysqli_query($conn, $data);
                $d = mysqli_fetch_array($query);
              ?>

              <!-- Horizontal Form -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id_produk" value="<?php echo $d['id_produk'] ?>" />
                    <input type="text" class="form-control" name="nama_produk" value="<?= $d["nama_produk"] ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="deskripsi_produk" value="<?= $d["deskripsi_produk"] ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Foto Produk</label>
                  <div class="col-sm-10">
                      <?php
                        if ($d['foto_produk'] == "") {
                        ?>
                            <div class="col-md-8 col-lg-9">
                                <div class="card" style="width: 100px; height:110px;">
                                    <img src="assets/img/file.png" alt="Profile">
                                    <a href="#" style="margin-top: 10px;" class="btn btn-sm" title="Upload new profile image">
                                        <input type="file" name="foto_produk" id="foto_produk" accept="image/*">
                                    </a>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-md-8 col-lg-9">
                                <div class="card" style="width: 100px; height:110px;">
                                    <img src="assets/img/<?= $d['foto_produk']; ?>" alt="Profile">
                                    <a href="#" style="margin-top: 10px;" class="btn btn-sm" title="Upload new profile image">
                                        <input type="file" name="foto_produk" id="foto_produk" accept="image/*">
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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