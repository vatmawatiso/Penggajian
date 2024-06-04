<?php

session_start();
include_once("koneksi.php");
require 'function.php';


include("koneksi.php");
$_SESSION['username'];

// kalau tidak ada id di query string
if (!isset($_SESSION['username'])) {
    header('Location: profil.php');
}

//ambil id dari query string
$username = $_SESSION['username'];

// buat query untuk ambil data dari database
$sql = "SELECT * FROM akun WHERE username = '$username'";
$query = mysqli_query($koneksi, $sql);
$akun = mysqli_fetch_assoc($query);

// jika data yang di-edit tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("data tidak ditemukan...");
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
      <h1>Edit Profil</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <?php
              if ($akun['photo'] == "") {
              ?>
                  <img src="assets/img/user.png" alt="Profile.php" class="rounded-circle">
              <?php
              } else {
              ?>
                  <img src="assets/img/<?= $akun['photo'] ?>" alt="Profile.php" class="rounded-circle">
              <?php
              }
              ?>
              <h2><?= $username; ?></h2>
              <h3>Admin</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->

                  <!-- Profile Edit Form -->
                  <form action="" method="post" enctype="multipart/form-data"> 
                    <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                            <?php
                            if ($akun['photo'] == "") {
                            ?>
                                <div class="col-md-8 col-lg-9">
                                    <div class="card" style="width: 100px; height:110px;">
                                        <img src="assets/img/user.png" alt="Profile">
                                        <a href="#" style="margin-top: 10px;" class="btn btn-sm" title="Upload new profile image">
                                            <input type="file" name="foto" id="foto" accept="image/*">
                                        </a>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-md-8 col-lg-9">
                                    <div class="card" style="width: 100px; height:110px;">
                                        <img src="assets/img/<?= $akun['photo']; ?>" alt="Profile">
                                        <a href="#" style="margin-top: 10px;" class="btn btn-sm" title="Upload new profile image">
                                            <input type="file" name="foto" id="foto" accept="image/*">
                                        </a>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                    </div>

                    <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="id_user" type="hidden" class="form-control" id="id_user" value="<?php echo $akun["id_user"]; ?>">
                        <input disabled name="username" type="text" class="form-control" id="username" value="<?= $akun["username"] ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="company" type="text" class="form-control" id="company" value="Aditya Ratan">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Pekerjaan</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="job" type="text" class="form-control" id="Job" value="Admin">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Negara</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="country" type="text" class="form-control" id="Country" value="Indonesia">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="address" type="text" class="form-control" id="Address" value="Desa Pamijahan Kec. Plumbon Kab. Cirebon Jawab Barat">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="telp" type="text" class="form-control" id="telp" value="<?= $akun["telp"] ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="email" type="email" class="form-control" id="Email" value="<?= $akun["email"] ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                  <?php
                        include_once("koneksi.php");
                        // cek apakah tombol simpan sudah diklik atau blum?
                        if (isset($_POST['update'])) {

                            // ambil data dari formulir
                            $id_user = $_POST['id_user'];
                            $username = $_POST['username'];
                            $email = $_POST['email'];
                            $telp = $_POST['telp'];

                            // buat query update
                            $sql = "UPDATE akun SET username='$username', email='$email', telp='$telp' WHERE id_user=$id_user";
                            $query = mysqli_query($conn, $sql);

                            // apakah query update berhasil?
                            if ($query) {
                                // kalau berhasil alihkan ke halaman list-siswa.php
                                echo "<script>alert('Berhaisl Ubah data profil'); window.location.href = 'profil.php';</script>";
                                
                            } else {
                                // kalau gagal tampilkan pesan
                                die("Gagal menyimpan perubahan...");
                            }

                            // Upload dan perbarui foto jika dipilih
                            if ($_FILES["foto"]["name"] != "") {
                                $targetDir = "assets/img/";
                                $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                                // Periksa apakah file gambar
                                $check = getimagesize($_FILES["foto"]["tmp_name"]);
                                if ($check !== false) {
                                    // Periksa ukuran file
                                    if ($_FILES["foto"]["size"] > 500000) {
                                        echo "Maaf, file terlalu besar.";
                                        $uploadOk = 0;
                                    }

                                    // Periksa jenis file
                                    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                                        echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
                                        $uploadOk = 0;
                                    }

                                    // Periksa jika $uploadOk bernilai 0
                                    if ($uploadOk == 0) {
                                        echo "Maaf, file tidak diunggah.";
                                    } else {
                                        // Jika semua kondisi terpenuhi, coba unggah file
                                        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
                                            // Perbarui path foto pengguna di database
                                            $fotoPath = basename($_FILES["foto"]["name"]);
                                            $conn->query("UPDATE akun SET photo='$fotoPath' WHERE id_user=$id_user");
                                            echo "Foto berhasil diunggah dan profil diperbarui.";
                                        } else {
                                            echo "Terjadi kesalahan saat mengunggah file.";
                                        }
                                    }
                                } else {
                                    echo "File bukan file gambar.";
                                }
                            }
                        }
                        ?>
</div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->
