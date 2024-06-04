<?php
session_start();
include_once("koneksi.php");
require "session.php";
require 'function.php';

$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];

// QUERY GET DATA AKUN
$sql = "SELECT * FROM akun WHERE username = '$username'";
$query = mysqli_query($koneksi, $sql);
$akun = mysqli_fetch_assoc($query);

?>

<!-- ======= Header ======= -->
<?php include "template/header.php"; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include "template/sidebar.php"; ?>
<!-- End Sidebar -->

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profil</h1>
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
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Detail Profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                    <div class="col-lg-9 col-md-8"><?= $akun["username"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Perusahaan</div>
                    <div class="col-lg-9 col-md-8">Aditya Ratan</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Pekerjaan</div>
                    <div class="col-lg-9 col-md-8">Admin</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Negara</div>
                    <div class="col-lg-9 col-md-8">Indonesia</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8">Desa Pamijahan Kec. Plumbon Kab. Cirebon Jawab Barat</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Telepon</div>
                    <div class="col-lg-9 col-md-8"><?= $akun["telp"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $akun["email"]; ?></div>
                  </div>

                </div>

                <div class="row mb-3">
                <label for="inputText" class="col-sm-10 col-form-label"></label>
                <div class="col-sm-4">
                  <a href="update_profil.php?id=<?php echo $akun['id_user']; ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                </div>
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
End Footer
