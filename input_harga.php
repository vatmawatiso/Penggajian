<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH BAGIAN
if (isset($_POST['submit'])) {

  if (insertHarga($_POST) > 0) {
      echo "<script>alert('Berhasil tambah harga!')</script>";
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
      <h1>INPUT DATA HARGA</h1>
    </div><!-- End Page Title -->
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Harga Produk dan Bagian</h5>

                <form action="" method="POST">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <select name="id_produk" class="form-select" aria-label="Default select example" required>
                                <option selected>Pilih jenis produk</option>
                                <?php
                                    include "koneksi.php";
                                    //query menampilkan nama unit kerja ke dalam combobox
                                    $query    = mysqli_query($conn, "SELECT * FROM produk");
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <option value=" <?= $data['id_produk']; ?>"><?php echo $data['nama_produk']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Bagian</label>
                        <div class="col-sm-10">
                            <select name="id_bagian" class="form-select" aria-label="Default select example" required>
                                <option selected>Pilih jenis bagian</option>
                                <?php
                                    include "koneksi.php";
                                    //query menampilkan nama unit kerja ke dalam combobox
                                    $query    = mysqli_query($conn, "SELECT * FROM bagian");
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <option value=" <?= $data['id_bagian']; ?>"><?php echo $data['nama_bagian']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" name="harga" class="form-control" placeholder="Masukkan harga" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan Harga</button>
                        </div>
                    </div>
                </form>

                <!-- Table with stripped rows -->
                <table class="table datatable">
                    <thead>
                      <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Bagian</th>
                          <th scope="col">Nama Produk</th>
                          <th scope="col">Harga</th>
                          <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php 
                      include 'koneksi.php';
                      $no = 1;
                      $data = mysqli_query($koneksi,"SELECT harga.*, produk.nama_produk, bagian.nama_bagian from harga 
                                                     join produk on harga.id_produk = produk.id_produk 
                                                     join bagian on harga.id_bagian = bagian.id_bagian;"
                                                     );
                      while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <th scope="row"><?= $no++; ?></th>
                      <td><?= $d["nama_produk"]; ?></td>
                      <td><?= $d["nama_bagian"]; ?></td>
                      <td>Rp <?= $d["harga"]; ?></td>
                      <td>
                        <a href="update_harga.php?id=<?php echo $d['id_harga']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="hapus_harga.php?id=<?php echo $d['id_harga']; ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i>  Hapus</a>
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