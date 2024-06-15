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
$nik = "";
$alamat = "";
$jabatan = "";

include "koneksi.php";

// Fungsi untuk menghapus data dari session
function hapusDataGaji($index) {
    if (isset($_SESSION['data_gaji'][$index])) {
        unset($_SESSION['data_gaji'][$index]);
        $_SESSION['data_gaji'] = array_values($_SESSION['data_gaji']);
    }
}

//GET DATA KARYAWAN
$sql = "SELECT * FROM karyawan";
$query = mysqli_query($koneksi, $sql);
$data_kry = mysqli_fetch_assoc($query);

//SIMPAN KE SESSION
$_SESSION['DATAS'] = $data_kry;

if (isset($_POST['hasil'])) {
    // Ambil data dari POST select
    $nmKaryawan = $_POST["karyawan"] ?? "";
    $nmProduk = $_POST["produk"] ?? "";
    $nmBagian = $_POST["bagian"] ?? "";
    $bil1 = $_POST['bil1'] ?? 0;
    $bil2 = $_POST['bil2'] ?? 0;
    $operasi = $_POST['operasi'] ?? '';
    // $NIK = $_POST["NIK"] ?? "";

    // Pisahkan nilai menjadi tiga bagian
    list($nama_karyawan, $NIK, $alamat_kry) = explode('|', $nmKaryawan);

    // Simpan ke variabel lain jika perlu
    $nm_karyawan = $nama_karyawan;
    $nm_produk = $nmProduk;
    $nm_bagian = $nmBagian;
    $nik_karyawan = $NIK;

        // Gunakan nilai sesuai kebutuhan Anda
        echo "Nama Karyawan: " . htmlspecialchars($nm_karyawan) . "<br>";
        echo "NIK Karyawan: " . htmlspecialchars($nik_karyawan) . "<br>";
        echo "alamat Karyawan: " . htmlspecialchars($alamat_kry) . "<br>";


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

    $hasil_rupiah = number_format($hasil, 0, ',', '.');
    $harga_rupiah = number_format($bil1, 0, ',', '.');

    // Simpan data ke session
    $_SESSION['data_gaji'][] = [
        'nama_karyawan' => $nm_karyawan,
        'nama_bagian' => $nm_bagian,
        'nama_produk' => $nm_produk,
        'harga' => $harga_rupiah,
        'hasil' => $hasil_rupiah,
        'bil2' => $bil2,
        'subtotal' => $subtotal_rupiah,
        'DATAS' => $data_kry,
        'alamat' => $alamat_kry,
        'NIK' => $nik_karyawan,
    ];

        // Insert data ke tabel laporan
        $nm_karyawan = $nm_karyawan;
        $nik = $nik_karyawan;
        $jabatan = $data_kry['jabatan'];
        $alamat = $alamat_kry;
        $nm_produk = $nm_produk;
        $nm_bagian = $nm_bagian;
        $bil1 = $bil1;
        $bil2 = $bil2;
        $hasil = $hasil;
        $tanggal_gajian = date('Y-m-d');

        $query_insert = "INSERT INTO `laporan`(`nm_karyawan`, `nik_karyawan`, `jabatan_karyawan`, `alamat_karyawan`, `produk`, `bagian`, `harga`, `jumlah`, `total`, `tanggal_gajian`) 
                         VALUES ('$nm_karyawan', '$nik', '$jabatan', '$alamat', '$nm_produk', '$nm_bagian', '$bil1', '$bil2', '$hasil', '$tanggal_gajian')";

                        //  var_dump($query_insert);
                        //  die();
        $query = mysqli_query($koneksi, $query_insert);
            if ($query) {
                echo "Data berhasil disimpan ke tabel laporan.";
            } else {
                echo "Gagal menyimpan data ke tabel laporan: " . mysqli_error($koneksi);
            }

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
    $hasil = str_replace('Rp ', '', $gaji['total']);
    $hasil = str_replace('.', '', $hasil);
    $subtotal += (int) $hasil;
}
$subtotal_rupiah =number_format($subtotal, 0, ',', '.');

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
                      $sql = mysqli_query($koneksi, "SELECT * FROM karyawan") or die(mysqli_error($koneksi));
                      while ($data = mysqli_fetch_array($sql)) {                   
                    ?>
                      <option value="<?=$data['nama_karyawan']?>|<?=$data['NIK']?>|<?=$data['alamat']?>"><?=$data['nama_karyawan']?></option> 
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
                      while ($data = mysqli_fetch_array($sql)) {
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
                        GROUP BY produk.nama_produk;") or die(mysqli_error($koneksi));
                      while ($data = mysqli_fetch_array($sql)) {
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
                    <input type="number" name="bil2" class="form-control" placeholder="Masukkan jumlah yang dikerjakan">
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
                  <a href="slip_gaji.php" class="btn btn-success" target="_BLANK"><i class="bi bi-printer-fill"></i> Cetak</a>
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
                    <th scope="col">QTY</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($data_gaji)) : ?>
                      <?php foreach ($data_gaji as $index => $gaji) : ?>
                      <tr>
                          <th scope="row"><?= $index + 1; ?></th>
                          <td><?= $gaji['nm_karyawan']; ?></td>
                          <td><?= $gaji['bagian']; ?></td>
                          <td><?= $gaji['produk']; ?></td>
                          <td><?= $gaji['jumlah']; ?></td>
                          <td><?= 'Rp ' . number_format($gaji['harga'], 0, ',', '.'); ?></td>
                          <td><?= 'Rp ' . number_format($gaji['total'], 0, ',', '.'); ?></td>
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
                    <td style="text-align: left;"><strong>Total:</strong></td>
                    <td style="font-size: 1.5em;">Rp <?= $subtotal_rupiah; ?></td>
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
