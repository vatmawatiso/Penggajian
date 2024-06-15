<?php

session_start();
include_once("koneksi.php");
require 'function.php';

//KONDISI KETIKA KLIK BUTTON UBAH HARGA
$alert_message = '';
$alert_class = '';

// if (isset($_POST['submit'])) {
//     $result = updateHarga($_POST);
  
//     if ($result['success']) {
//         $alert_message = 'Berhasil mengubah data harga!';
//         $alert_class = 'alert-success';
//     } else {
//         $alert_message = $result['message'];
//         $alert_class = 'alert-danger';
//     }
  
//     echo "<script>
//             setTimeout(function() {
//                 window.location.href = 'input_harga.php';
//             }, 3000);
//           </script>";
//   }

  if (isset($_POST['submit'])) {
    $result = updateHarga($_POST);

    if ($result === -1) {
        $alert_message = 'Gagal mengubah harga. Harga untuk kombinasi produk dan bagian tersebut sudah ada.';
        $alert_class = 'alert-danger';
    } elseif ($result > 0) {
        $alert_message = 'Berhasil mengubah harga!';
        $alert_class = 'alert-success';
    } else {
        $alert_message = 'Gagal mengubah harga.';
        $alert_class = 'alert-danger';
    }

    echo "<script>
            setTimeout(function() {
                window.location.href = 'input_harga.php';
            }, 3000);
          </script>";
}

  // Ambil data dari tabel produk
    $query = "SELECT id_produk, nama_produk FROM produk";
    $result = mysqli_query($koneksi, $query);

    // Ambil data dari tabel bagian
    $query = "SELECT id_bagian, nama_bagian FROM bagian";
    $result_bagian = mysqli_query($koneksi, $query);

    // Ambil data id_harga (misal dari parameter GET)
    $id_harga = $_GET['id_harga'];

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

                <?php
                    include 'koneksi.php';
                    $id = $_GET['id'];
                    $data = "SELECT harga.*, produk.nama_produk, bagian.nama_bagian from harga 
                             join produk on harga.id_produk = produk.id_produk 
                             join bagian on harga.id_bagian = bagian.id_bagian WHERE id_harga = '$id'";
                    $query = mysqli_query($conn, $data);
                    $d = mysqli_fetch_array($query);
                    $selected_id_produk = $d['id_produk'];
                    $selected_id_bagian = $d['id_bagian'];
                ?>

                <form action="" method="POST">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Bagian</label>
                        <div class="col-sm-10">
                            <select name="id_bagian" class="form-select" aria-label="Default select example">
                                <option value=" <?= $d['id_bagian']; ?>"><?php echo $d['nama_bagian']; ?></option>
                                <?php
                                    while ($row = mysqli_fetch_assoc($result_bagian)) {
                                        $selected = ($row['id_bagian'] == $selected_id_bagian) ? 'selected' : '';
                                        echo "<option value='{$d['id_bagian']}' $selected>{$row['nama_bagian']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Produk</label>
                        <input type="hidden" name="id_harga" value="<?php echo $d['id_harga'] ?>" />
                        <div class="col-sm-10">
                            <select name="id_produk" class="form-select" aria-label="Default select example">
                                <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['id_produk'] == $selected_id_produk) ? 'selected' : '';
                                        echo "<option value='{$d['id_produk']}' $selected>{$row['nama_produk']}</option>";
                                    }
                                ?>
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