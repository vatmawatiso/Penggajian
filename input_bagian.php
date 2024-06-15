<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH BAGIAN
$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
  $result = insertBagian($_POST);

  if ($result['success']) {
      $alert_message = 'Berhasil menambahkan data bagian!';
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

//HAPUS BAGIAN
if (isset($_GET['delete_status'])) {
  $delete_status = $_GET['delete_status'];

  if ($delete_status == 'success') {
      $alert_message = 'Data bagian berhasil dihapus!';
      $alert_class = 'alert-success';
  } elseif ($delete_status == 'error') {
      $alert_message = 'Gagal menghapus data bagian!';
      $alert_class = 'alert-danger';
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
      <h1>INPUT DATA BAGIAN</h1>
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
                <h5 class="card-title">Bagian Rattan</h5>

                <form action="" method="POST">
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Nama Bagian</label>
                    <div class="col-sm-4">
                      <input type="text" name="nama_bagian" class="form-control" placeholder="Masukkan nama bagian" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                      <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </form>

                <!-- Table with stripped rows -->
                <table class="table datatable">
                    <thead>
                      <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Bagian</th>
                          <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php 
                      include 'koneksi.php';
                      $no = 1;
                      $data = mysqli_query($koneksi,"SELECT * FROM `bagian`");
                      while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <th scope="row"><?= $no++; ?></th>
                      <td><?= $d["nama_bagian"]; ?></td>
                      <td>
                        <a href="update_bagian.php?id=<?php echo $d['id_bagian']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="hapus_bagian.php?id=<?php echo $d['id_bagian']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus bagian ini?')"><i class="bi bi-trash-fill"></i>  Hapus</a>
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