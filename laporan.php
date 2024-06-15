<?php

// session_start();
include_once("koneksi.php");
require 'function.php';

function formatTanggalIndonesia($tanggal) {
  $bulanIndo = [
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember'
  ];

  $hariIndo = [
      'Sunday' => 'Minggu',
      'Monday' => 'Senin',
      'Tuesday' => 'Selasa',
      'Wednesday' => 'Rabu',
      'Thursday' => 'Kamis',
      'Friday' => 'Jumat',
      'Saturday' => 'Sabtu'
  ];

  $date = strtotime($tanggal);
  $hari = $hariIndo[date('l', $date)];
  $tanggal = date('d', $date);
  $bulan = $bulanIndo[(int)date('m', $date)];
  $tahun = date('Y', $date);

  return "$hari, $tanggal $bulan $tahun";
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
      <h1>LAPORAN</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Laporan Gaji Karyawan</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal Gajian</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    include 'koneksi.php';
                    $no = 1;
                    $today = date('Y-m-d');
                    $data = mysqli_query($koneksi, "SELECT nm_karyawan, nik_karyawan, jabatan_karyawan, alamat_karyawan, tanggal_gajian 
                                                    FROM laporan 
                                                    GROUP BY nm_karyawan, tanggal_gajian 
                                                    ORDER BY ABS(DATEDIFF(tanggal_gajian, '$today')) ASC
                                        ");
                    // $data = mysqli_query($koneksi,"SELECT nm_karyawan, nik_karyawan, jabatan_karyawan, alamat_karyawan, tanggal_gajian 
                    //                                FROM laporan GROUP BY nm_karyawan, tanggal_gajian ORDER BY tanggal_gajian ASC");

                    while($d = mysqli_fetch_array($data)){
                        $nm_karyawan = $d['nm_karyawan'];
                        $tanggal_gajian = $d['tanggal_gajian'];
                        // Memformat tanggal
                        $formatted_date = formatTanggalIndonesia($tanggal_gajian);
                ?>
                  <tr>
                    <th scope="row"><?= $no; ?></th>
                    <td><?= $nm_karyawan; ?></td>
                    <td><?= $d["nik_karyawan"]; ?></td>
                    <td><?= $d["jabatan_karyawan"]; ?></td>
                    <td><?= $d["alamat_karyawan"]; ?></td>
                    <td><?= $formatted_date ?></td>
                    <td>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal<?= $no; ?>">
                        Detail
                      </button>
                      <a href="delete_laporan.php?nm_karyawan=<?= urlencode($nm_karyawan); ?>&tanggal_gajian=<?= $tanggal_gajian; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')"><i class="bi bi-trash"></i> Hapus</a>
                      <a href="generate_pdf.php?nm_karyawan=<?= urlencode($nm_karyawan); ?>&tanggal_gajian=<?= $tanggal_gajian; ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin mendownload laporan ini?')" target="_BLANK"><i class="bi bi-download"></i> Download</a>
                    </td>
                  </tr>
                
                  <!-- Modal -->
                  <div class="modal fade" id="detailModal<?= $no; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $no; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="detailModalLabel<?= $no; ?>">Detail Karyawan: <?= $nm_karyawan; ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?php
                            $detailData = mysqli_query($koneksi, "SELECT produk, bagian, harga, jumlah, total, tanggal_gajian FROM laporan WHERE nm_karyawan = '$nm_karyawan' AND tanggal_gajian = '$tanggal_gajian'");
                            $totalKeseluruhan = 0;
                            $bagianDisplayed = []; // Array untuk menyimpan nama bagian yang sudah ditampilkan

                            while($detail = mysqli_fetch_array($detailData)){
                              $totalKeseluruhan += $detail['total'];
                          ?>
                              <?php if (!in_array($detail['tanggal_gajian'], $bagianDisplayed)) {
                                $bagianDisplayed[] = $detail['tanggal_gajian']; // Tanggal
                              ?>
                                <p><strong>Tanggal Gajian:</strong> <?= $detail['tanggal_gajian']; ?></p>
                              <?php } ?>
                              <?php if (!in_array($detail['bagian'], $bagianDisplayed)) {
                                $bagianDisplayed[] = $detail['bagian']; // Tambahkan nama bagian ke array
                              ?>
                                <p><strong>Nama Bagian:</strong> <?= $detail['bagian']; ?></p>
                              <?php } ?>

                              <hr> 
                              <p><strong>Nama Produk:</strong> <?= $detail['produk']; ?></p>
                              <p><strong>Harga:</strong> <?= 'Rp ' . number_format($detail['harga'], 0, ',', '.'); ?></p>
                              <p><strong>Jumlah:</strong> <?= $detail['jumlah']; ?></p>
                              <p><strong>Total:</strong> <?= 'Rp ' . number_format($detail['total'], 0, ',', '.'); ?></p>
                              <hr>
                          <?php
                            }
                          ?>
                          <p><strong>Total Gaji Karyawan:</strong> <?= 'Rp ' . number_format($totalKeseluruhan, 0, ',', '.'); ?></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php 
                       $no++;
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
