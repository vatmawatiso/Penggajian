<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH BAGIAN
if (isset($_POST['submit'])) {

  if (updateHarga($_POST) > 0) {
      echo "<script>alert('Berhasil ubah data harga!')</script>";
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
      <h1>Input Harga</h1>
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
                <h5 class="card-title">Harga Produk dan Bagian</h5>

                <?php
                    include 'koneksi.php';
                    $id = $_GET['id'];
                    $data = "SELECT harga.*, produk.nama_produk, bagian.nama_bagian from harga 
                             join produk on harga.id_produk = produk.id_produk 
                             join bagian on harga.id_bagian = bagian.id_bagian WHERE id_harga = '$id'";
                    $query = mysqli_query($conn, $data);
                    $d = mysqli_fetch_array($query);
                ?>

                <form action="" method="POST">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                        <input type="hidden" name="id_harga" value="<?php echo $d['id_harga'] ?>" />
                        <div class="col-sm-10">
                            <select name="id_produk" class="form-select" aria-label="Default select example">
                                <option value=" <?= $d['id_produk']; ?>"><?php echo $d['nama_produk']; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Bagian</label>
                        <div class="col-sm-10">
                            <select name="id_bagian" class="form-select" aria-label="Default select example">
                                <option value=" <?= $d['id_bagian']; ?>"><?php echo $d['nama_bagian']; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" name="harga" class="form-control" value="<?= $d["harga"] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan Harga</button>
                        </div>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </section>


  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->