<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
    $result = updateKonsumen($_POST);
    $source = strtolower(stripslashes($_POST["source"]));

    if ($result > 0) {
        $alert_message = 'Berhasil ubah data konsumen!';
        $alert_class = 'alert-success';
    } else {
        $alert_message = 'Gagal ubah data konsumen!';
        $alert_class = 'alert-danger';
    }

    echo "<script>
            setTimeout(function() {
                window.location.href = '$source.php';
            }, 3000);
          </script>";
}

// if (isset($_POST['submit'])) {

//     if (updateKonsumen($_POST) > 0) {
//         echo "<script>alert('Berhasil ubah data konsumen!')</script>";
//     } else {
//         echo mysqli_error($conn);
//     }
// }
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
          <?php if ($alert_message): ?>
              <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                  <?php echo $alert_message; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Konsumen</h5>
              
              <?php
                include 'koneksi.php';
                $id = $_GET['id'];
                $source = $_GET['source'];
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