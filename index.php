<?php

session_start();
include_once("koneksi.php");
require "function.php";
require "session.php";

// QUERY GET DATA KARYAWAN AKTIF
$sql = "SELECT COUNT(nama_karyawan) FROM karyawan WHERE status='1'";
$query = mysqli_query($koneksi, $sql);
$kry = mysqli_fetch_assoc($query);
$kry_aktif = implode(", ",$kry);

// QUERY GET DATA KARYAWAN tIDAK AKTIF
$sql = "SELECT COUNT(nama_karyawan) FROM karyawan WHERE status='0'";
$query = mysqli_query($koneksi, $sql);
$kry = mysqli_fetch_assoc($query);
$kry_nonaktif = implode(", ",$kry);

// QUERY GET DATA KONSUMEN BELUM SELESAI
$sql = "SELECT COUNT(nama_konsumen) FROM konsumen WHERE proses='1'";
$query = mysqli_query($koneksi, $sql);
$kry = mysqli_fetch_assoc($query);
$ksm_aktif = implode(", ",$kry);

// QUERY GET DATA KONSUMEN SUDAH SELESAI
$sql = "SELECT COUNT(nama_konsumen) FROM konsumen WHERE proses='0'";
$query = mysqli_query($koneksi, $sql);
$kry = mysqli_fetch_assoc($query);
$ksm_nonaktif = implode(", ",$kry);

?>

<!-- ======= Header ======= -->
<?php include "template/header.php"; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include "template/sidebar.php"; ?>
<!-- End Sidebar -->

    <!-- Halaman Awal Dashboard-->
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Dashboard</h1>
      </div>
      <!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">
          <!-- Left side columns -->
          <div class="col-lg-10">
            <div class="row">
              <!-- Karyawan Aktif -->
              <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Karyawan <span>| Aktif</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus-fill"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?= $kry_aktif; ?> Karyawan</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Karyawan Aktif -->

              <!-- Karyawan Non Aktif -->
              <div class="col-xxl-6 col-md-6">
                <div class="card info-card revenue-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Karyawan <span>| Tidak Aktif</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-dash-fill"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?= $kry_nonaktif; ?> Karyawan</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Karyawan Non Aktif -->

              <!-- Konsumen Aktfi -->
              <div class="col-xxl-6 col-xl-12">
                <div class="card info-card customers-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Klien <span>| Kontrak Belum Selesai</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?= $ksm_aktif; ?> Klien / Konsumen</h6>
                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Konsumen Aktfi -->

              <!-- Konsumen Non Aktif -->
              <div class="col-xxl-6 col-xl-12">
                <div class="card info-card customers-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Klien <span>| Kontrak Selesai</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?= $ksm_nonaktif; ?> Klien / Konsumen</h6>
                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Konsumen Non Aktif -->

            </div>
          </div>
          <!-- End Left side columns -->
        </div>
      </section>
    </main>
    <!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->
