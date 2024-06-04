<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH BAGIAN
if (isset($_POST['tambah'])) {

  if (insertBagian($_POST) > 0) {
      echo "<script>alert('Berhasil tambah bagian!')</script>";
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
      <h1>INPUT DATA BAGIAN</h1>
    </div><!-- End Page Title -->
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

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
                        <a href="hapus_bagian.php?id=<?php echo $d['id_bagian']; ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i>  Hapus</a>
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