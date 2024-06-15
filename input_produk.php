<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH PRODUK
$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
  $result = insertProduk($_POST);

  if ($result['success']) {
      $alert_message = 'Berhasil menambahkan data produk!';
      $alert_class = 'alert-success';
  } else {
      $alert_message = $result['message'];
      $alert_class = 'alert-danger';
  }

  echo "<script>
          setTimeout(function() {
              window.location.href = 'input_produk.php';
          }, 9000);
        </script>";
}

//HAPUS PRODUK
if (isset($_GET['delete_status'])) {
  $delete_status = $_GET['delete_status'];

  if ($delete_status == 'success') {
      $alert_message = 'Data produk berhasil dihapus!';
      $alert_class = 'alert-success';
  } elseif ($delete_status == 'error') {
      $alert_message = 'Gagal menghapus data produk!';
      $alert_class = 'alert-danger';
  }
}

// buat query untuk ambil data dari database
$sql = "SELECT * FROM produk";
$query = mysqli_query($koneksi, $sql);
$datas = mysqli_fetch_assoc($query);

?>

<!-- ======= Header ======= -->
<?php include "template/header.php"; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include "template/sidebar.php"; ?>
<!-- End Sidebar -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>INPUT DATA PRODUK</h1>
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
              <h5 class="card-title">Jenis Produk Rattan</h5>

              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Nama Produk</label>
                    <div class="col-sm-4">
                      <input type="text" name="nama_produk" class="form-control" placeholder="Masukkan nama produk" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                    <div class="col-sm-4">
                      <input type="text" name="deskripsi_produk" class="form-control" placeholder="Masukkan deskripsi produk" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Foto Produk</label>
                    <div class="col-sm-4">
                          <?php
                          if ($datas['foto_produk'] == "") {
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
                                      <img src="assets/img/<?= $datas['foto_produk']; ?>" alt="Profile">
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
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Foto Produk</th>
                    <th scope="col">Deskripsi Produk</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    include 'koneksi.php';
                    $no = 1;
                    $data = mysqli_query($koneksi,"SELECT * FROM `produk`");
                    while($d = mysqli_fetch_array($data)){
                  ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $d["nama_produk"]; ?></td>
                    <td>
                        <?php if (!empty($d["foto_produk"])): ?>
                          <img src="assets/img/<?= $d['foto_produk']; ?>" alt="Foto Produk" style="width: 100px; height: auto;">
                        <?php else: ?>
                          Tidak ada gambar
                        <?php endif; ?>
                    </td>
                    <td><?= $d["deskripsi_produk"]; ?></td>
                    <td>
                        <a href="update_produk.php?id=<?php echo $d['id_produk']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="hapus_produk.php?id=<?php echo $d['id_produk']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"><i class="bi bi-trash-fill"></i>  Hapus</a>
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