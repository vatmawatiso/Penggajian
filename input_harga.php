<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON TAMBAH HARGA
$alert_message = '';
$alert_class = '';

// if (isset($_POST['submit'])) {
//     $result = insertHarga($_POST);
  
//     if ($result['success']) {
//         $alert_message = 'Berhasil menambahkan data harga!';
//         $alert_class = 'alert-success';
//     } else {
//         $alert_message = $result['message'];
//         $alert_class = 'alert-danger';
//     }
  
//     echo "<script>
//             setTimeout(function() {
//                 window.location.href = 'input_harga.php';
//             }, 9000);
//           </script>";
//   }

if (isset($_POST['submit'])) {
    $result = insertHarga($_POST);

    if ($result === -1) {
        $alert_message = 'Gagal menambahkan harga. Harga untuk kombinasi produk dan bagian tersebut sudah ada.';
        $alert_class = 'alert-danger';
    } elseif ($result > 0) {
        $alert_message = 'Berhasil menambahkan harga!';
        $alert_class = 'alert-success';
    } else {
        $alert_message = 'Gagal menambahkan harga.';
        $alert_class = 'alert-danger';
    }

    echo "<script>
            setTimeout(function() {
                window.location.href = 'input_harga.php';
            }, 3000);
          </script>";
}

//HAPUS HARGA
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
      <h1>INPUT DATA HARGA</h1>
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
                <h5 class="card-title">Harga Produk dan Bagian</h5>

                <form action="" method="POST">
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
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="id_harga" value="<?php echo $d['id_harga'] ?>" />
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
                      <td><?= $d["nama_bagian"]; ?> <?= $d["id_bagian"]; ?></td>
                      <td><?= $d["nama_produk"]; ?> <?= $d["id_produk"]; ?></td>
                      <td>Rp <?= $d["harga"]; ?></td>
                      <td>
                        <a href="update_harga.php?id=<?php echo $d['id_harga']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="hapus_harga.php?id=<?php echo $d['id_harga']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus harga ini?')"><i class="bi bi-trash-fill"></i>  Hapus</a>
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