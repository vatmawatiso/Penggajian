<?php
include_once("koneksi.php");
require 'function.php';

$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
    if (updateStatusKB($_POST) > 0) {
        $alert_message = 'Berhasil ubah status karyawan!';
        $alert_class = 'alert-success';
    } else {
        $alert_message = 'Gagal ubah status karyawan!';
        $alert_class = 'alert-danger';
    }
    echo "<script>
            setTimeout(function() {
                window.location.href = 'karyawan_lama.php';
            }, 3000);
          </script>";
}

if (isset($_GET['delete_status'])) {
    $delete_status = $_GET['delete_status'];

    if ($delete_status == 'success') {
        $alert_message = 'Data karyawan berhasil dihapus!';
        $alert_class = 'alert-success';
    } elseif ($delete_status == 'error') {
        $alert_message = 'Gagal menghapus data karyawan!';
        $alert_class = 'alert-danger';
    }
}

if (isset($_GET['status'])) {
  $status = $_GET['status'];

  if ($status == 'success') {
      $alert_message = 'Status karyawan berhasil diubah!';
      $alert_class = 'alert-success';
  } elseif ($status == 'error') {
      $alert_message = 'Gagal mengubah status karyawan!';
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
        <h1>DATA KARYAWAN ADITYA ROTAN</h1>
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
                        <h5 class="card-title">Karyawan Tidak Aktif</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Karyawan</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Tahun Masuk</th>
                                    <th scope="col">No Rekening</th>
                                    <th scope="col">Nama Bank</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Toggle</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                include 'koneksi.php';
                                $no = 1;
                                $data = mysqli_query($koneksi, "SELECT * FROM `karyawan` WHERE status = 'Tidak Aktif'");
                                while ($d = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?= $d["nama_karyawan"]; ?></td>
                                        <td><?= $d["NIK"]; ?></td>
                                        <td><?= $d["jenis_kelamin"]; ?></td>
                                        <td><?= $d["nomer_hp"]; ?></td>
                                        <td><?= $d["alamat"]; ?></td>
                                        <td><?= $d["jabatan"]; ?></td>
                                        <td><?= $d["thn_masuk"]; ?></td>
                                        <td><?= $d["no_rek"]; ?></td>
                                        <td><?= $d["bank"]; ?></td>
                                        <td><?= ($d["status"] == "1") ? 'Aktif' : 'Tidak Aktif'; ?></td>
                                        <td>
                                            <?php if ($d['status'] == "1") { ?>
                                                <a href="nonaktif.php?id=<?php echo $d['id_karyawan']; ?>"><span class="badge bg-danger">Tidak Aktif</span></a>
                                            <?php } else { ?>
                                                <a href="aktif.php?id=<?php echo $d['id_karyawan']; ?>"><span class="badge bg-success">Aktif</span></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="update_karyawan.php?id=<?php echo $d['id_karyawan']; ?>&source=karyawan_lama" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <a href="delete_karyawan.php?id=<?php echo $d['id_karyawan']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')"><i class="bi bi-trash"></i> Hapus</a>
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
