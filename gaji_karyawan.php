<?php
session_start();

// Menginisialisasi variabel dengan nilai default kosong
$nm_karyawan = "";
$nm_bagian = "";
$nm_produk = "";
$hasil = "";
$hasil_rupiah = "";
$harga_rupiah = "";
$bil2 = "";
$subtotal_rupiah = "";

include "koneksi.php";

// Fungsi untuk menghapus data dari session
function hapusDataGaji($index) {
    if (isset($_SESSION['data_gaji'][$index])) {
        unset($_SESSION['data_gaji'][$index]);
        $_SESSION['data_gaji'] = array_values($_SESSION['data_gaji']);
    }
}

if (isset($_POST['hasil'])) {
    // Ambil data dari POST
    $nmKaryawan = $_POST["karyawan"] ?? "";
    $nmProduk = $_POST["produk"] ?? "";
    $nmBagian = $_POST["bagian"] ?? "";
    $bil1 = $_POST['bil1'] ?? 0;
    $bil2 = $_POST['bil2'] ?? 0;
    $operasi = $_POST['operasi'] ?? '';

    // Simpan ke variabel lain jika perlu
    $nm_karyawan = $nmKaryawan;
    $nm_produk = $nmProduk;
    $nm_bagian = $nmBagian;

    // Query untuk mengambil data harga berdasarkan produk dan bagian
    $sql = "SELECT 
              p.nama_produk AS Produk,
              b.nama_bagian AS Bagian,
              h.harga AS Harga
            FROM 
              harga h
            JOIN 
              produk p ON h.id_produk = p.id_produk
            JOIN 
              bagian b ON h.id_bagian = b.id_bagian
            WHERE
              (p.nama_produk = '$nm_produk' AND b.nama_bagian = '$nm_bagian')";
              
    $query = mysqli_query($koneksi, $sql);
    
    if ($query) {
        $data = mysqli_fetch_array($query) ?: ['Harga' => 0];
    }

    // Proses perhitungan
    $bil1 = $data["Harga"] ?? 0; // Harga dari produk dan bagian yang dipilih
    $bil2 = $_POST['bil2'] ?? 0;
    $operasi = $_POST['operasi'] ?? '';

    switch ($operasi) {
        case 'tambah':
            $hasil = $bil1 + $bil2;
            break;
        case 'kurang':
            $hasil = $bil1 - $bil2;
            break;
        case 'kali':
            $hasil = $bil1 * $bil2;
            break;
        case 'bagi':
            $hasil = $bil1 / $bil2;
            break;
    }

    $hasil_rupiah = "Rp " . number_format($hasil, 0, ',', '.');
    $harga_rupiah = "Rp " . number_format($bil1, 0, ',', '.');

    // Simpan data ke session
    $_SESSION['data_gaji'][] = [
        'nama_karyawan' => $nm_karyawan,
        'nama_bagian' => $nm_bagian,
        'nama_produk' => $nm_produk,
        'harga' => $harga_rupiah,
        'hasil' => $hasil_rupiah,
        'bil2' => $bil2,
        'subtotal' => $subtotal_rupiah,
    ];

}

// Menghapus data jika tombol hapus diklik
if (isset($_POST['hapus']) && isset($_POST['index'])) {
    hapusDataGaji($_POST['index']);
}

// Mengambil data dari session
$data_gaji = $_SESSION['data_gaji'] ?? [];

// Menghitung subtotal
$subtotal = 0;
foreach ($data_gaji as $gaji) {
    $hasil = str_replace('Rp ', '', $gaji['hasil']);
    $hasil = str_replace('.', '', $hasil);
    $subtotal += (int) $hasil;
}
$subtotal_rupiah = "Rp " . number_format($subtotal, 0, ',', '.');

// Simpan subtotal ke session
$_SESSION['subtotal'] = $subtotal_rupiah;

?>

<!-- ======= Header ======= -->
<?php include "template/header.php"; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include "template/sidebar.php"; ?>
<!-- End Sidebar -->

<main id="main" class="main">

  <div class="pagetitle">
    <h1>PERHITUNGAN GAJI KARYAWAN</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Slip Gaji Karyawan</h5>

            <!-- General Form Elements -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Pilih Karyawan</label>
                <div class="col-sm-10">
                  <select name="karyawan" class="form-select" aria-label="Default select example" required>
                    <option selected>Masukkan nama karyawan</option>
                    <?php 
                      $sql = mysqli_query($koneksi,"select * from karyawan") or die (mysqli_error($koneksi));
                      while ($data=mysqli_fetch_array($sql)) {
                    ?>
                      <option value="<?=$data['nama_karyawan']?>"><?=$data['nama_karyawan']?></option> 
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Pilih Bagian</label>
                <div class="col-sm-10">
                  <select name="bagian" class="form-select" aria-label="Default select example" required>
                    <option selected>Masukkan bagian</option>
                    <?php 
                        $sql = mysqli_query($koneksi, "SELECT bagian.nama_bagian, MIN(harga.id_harga) as id_harga, MIN(harga.harga) as harga
                        FROM harga
                        JOIN bagian ON harga.id_bagian = bagian.id_bagian
                        GROUP BY bagian.nama_bagian;") or die (mysqli_error($koneksi));
                      // $sql = mysqli_query($koneksi,"select * from bagian") or die (mysqli_error($koneksi));
                      while ($data=mysqli_fetch_array($sql)) {
                    ?>
                      <option value="<?=$data['nama_bagian']?>"><?=$data['nama_bagian']?></option> 
                    <?php
                       }
                    ?>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Pilih Produk</label>
                <div class="col-sm-10">
                  <select name="produk" class="form-select" aria-label="Default select example" required>
                    <option selected>Masukkan produk</option>
                    <?php 
                        $sql = mysqli_query($koneksi, "SELECT produk.nama_produk, MIN(harga.id_harga) as id_harga, MIN(harga.harga) as harga
                        FROM harga
                        JOIN produk ON harga.id_produk = produk.id_produk
                        GROUP BY produk.nama_produk;
                        ") or die (mysqli_error($koneksi));
                      // $sql = mysqli_query($koneksi,"select * from produk") or die (mysqli_error($koneksi));
                      while ($data=mysqli_fetch_array($sql)) {
                    ?>
                      <option value="<?=$data['nama_produk']?>"><?=$data['nama_produk']?></option> 
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                  <label for="inputText" class="col-sm-8 col-form-label"></label>
                  <div class="col-sm-4">
                    <input type="number" name="bil2" class="form-control" placeholder="Masukkan jumlah yang dikerjakan" required>
                  </div>
              </div>

              <div class="row mb-3">
                  <label class="col-sm-8 col-form-label"></label>
                  <div class="col-sm-4">
                    <select class="form-select" aria-label="Default select example" name="operasi" required>
                      <option selected>Masukan operator perhitungan</option>
                      <option value="tambah">+</option>
                      <option value="kurang">-</option>
                      <option value="kali">x</option>
                      <option value="bagi">/</option>
                    </select>
                  </div>
              </div>

              <div class="row mb-3">
                <label for="inputText" class="col-sm-8 col-form-label"></label>
                <div class="col-sm-4">
                  <button type="submit" name="hasil" class="btn btn-primary"><i class="bi bi-calculator-fill"></i> Hitung</button>
                  <a href="cetak_gaji.php" class="btn btn-success" target="_BLANK"><i class="bi bi-printer-fill"></i> Cetak</a>
                </div>
              </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Nama Bagian</th>
                    <th scope="col">Jenis Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total Kerja</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($data_gaji)) : ?>
                      <?php foreach ($data_gaji as $index => $gaji) : ?>
                      <tr>
                          <th scope="row"><?= $index + 1; ?></th>
                          <td><?= $gaji['nama_karyawan']; ?></td>
                          <td><?= $gaji['nama_bagian']; ?></td>
                          <td><?= $gaji['nama_produk']; ?></td>
                          <td><?= $gaji['harga']; ?></td>
                          <td><?= $gaji['bil2']; ?> Mengerjakan</td>
                          <td><?= $gaji['hasil']; ?></td>
                          <td>
                              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:inline;">
                                  <input type="hidden" name="index" value="<?= $index; ?>">
                                  <button type="submit" name="hapus" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Hapus</button>
                              </form>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  <?php endif; ?>
                  <tr>
                    <td style="text-align: left;"><strong>Subtotal:</strong></td>
                    <td style="font-size: 1.5em;"><?= $subtotal_rupiah; ?></td>
                    <td></td>
                  </tr>
                </tbody>  
              </table>
              <!-- End Table with stripped rows -->
            </form><!-- End General Form Elements -->

          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->
