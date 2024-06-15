<?php
include_once("koneksi.php");
require 'function.php';

$alert_message = '';
$alert_class = '';

if (isset($_POST['submit'])) {
    $result = updateKaryawan($_POST);
    $source = strtolower(stripslashes($_POST["source"]));

    if ($result['success']) {
        $alert_message = 'Berhasil mengubah data karyawan!';
        $alert_class = 'alert-success';
    } else {
        $alert_message = $result['message'];
        $alert_class = 'alert-danger';
    }

    echo "<script>
            setTimeout(function() {
                window.location.href = '$source.php';
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
                        <h5 class="card-title">Edit Karyawan</h5>
                        
                        <?php
                        $id = $_GET['id'];
                        $source = $_GET['source'];
                        $data = "SELECT * FROM karyawan WHERE id_karyawan = '$id'";
                        $query = mysqli_query($conn, $data);
                        $d = mysqli_fetch_array($query);
                        ?>

                        <form action="" method="post">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Karyawan</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="source" value="<?php echo $source; ?>" />
                                    <input type="hidden" name="id_karyawan" value="<?php echo $d['id_karyawan'] ?>" />
                                    <input type="text" class="form-control" name="nama_karyawan" value="<?php echo $d['nama_karyawan']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="NIK" id="NIK" value="<?php echo $d['NIK']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jenis_kelamin" value="<?php echo $d['jenis_kelamin']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nomer Telepon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomer_hp" value="<?php echo $d['nomer_hp']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alamat" value="<?php echo $d['alamat']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jabatan" value="<?php echo $d['jabatan']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">No Rekening</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="no_rek" value="<?php echo $d['no_rek']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Bank</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="bank" value="<?php echo $d['bank']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="thn_masuk" value="<?php echo $d['thn_masuk']; ?>" required>
                                </div>
                            </div>

                            <!-- Tombol Save -->
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
