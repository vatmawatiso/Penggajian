<?php 
  // Menginisialisasi variabel dengan nilai default kosong
  $nm_karyawan = "";
  $nm_bagian = "";
  $nm_produk = "";
  $hasil = ""; // Pastikan ini juga didefinisikan
  $data = ['Harga' => ""]; // Inisialisasi array dengan nilai default

  include "koneksi.php";

  if (isset($_POST['hasil'])) {
      // Logika untuk mengambil dan menampilkan data...
      $nmKaryawan = $_POST["karyawan"] ?? ""; // Null coalescing operator untuk PHP 7+
      $nmProduk = $_POST["produk"] ?? "";
      $nmBagian = $_POST["bagian"] ?? "";
      $bil1 = $_POST['bil1'] ?? 0;
      $bil2 = $_POST['bil2'] ?? 0;
      $operasi = $_POST['operasi'] ?? '';

      // Simpan ke variabel lain jika perlu
      $nm_karyawan = $nmKaryawan;
      $nm_produk = $nmProduk;
      $nm_bagian = $nmBagian;

      // Query untuk mengambil data...
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
              
      echo $sql;
      $query = mysqli_query($koneksi, $sql);
      
      if ($query) {
          $data = mysqli_fetch_array($query) ?: ['Harga' => ""]; // Tambahkan pemeriksaan apakah query berhasil dan data ada
          echo $data["Harga"];
      }

        // Proses perhitungan
        $bil1 = $_POST['bil1'] ?? 0;
        $bil2 = $_POST['bil2'] ?? 0;
        $operasi = $_POST['operasi'] ?? '';
        
        switch ($operasi) {
            case 'tambah':
                $hasil = $bil1 + $bil2; 
                $hasil_rupiah = "Rp " . number_format($hasil, 0, ',', '.');
                break;
            case 'kurang':
                $hasil = $bil1 - $bil2;
                $hasil_rupiah = "Rp " . number_format($hasil, 0, ',', '.');
                break;
            case 'kali':
                $hasil = $bil1 * $bil2;
                $hasil_rupiah = "Rp " . number_format($hasil, 0, ',', '.');
                break;
            case 'bagi':
                $hasil = $bil1 / $bil2;
                $hasil_rupiah = "Rp " . number_format($hasil, 0, ',', '.');
                break;
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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
    <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">SLIP GAJI KARYAWAN</h5>

              <!-- General Form Elements -->
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Pilih Karyawan</label>
                  <div class="col-sm-10">
                    <select name="karyawan" class="form-select" aria-label="Default select example">
                      <option selected>Masukkan nama karyawan</option>
                      <?php 
                        include "koneksi.php";
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
                    <select name="bagian" class="form-select" aria-label="Default select example">
                      <option selected>Masukkan bagian</option>
                      <?php 
                        include "koneksi.php";
                        $sql = mysqli_query($koneksi,"select * from bagian") or die (mysqli_error($koneksi));
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
                    <select name="produk" class="form-select" aria-label="Default select example">
                      <option selected>Masukkan produk</option>
                      <?php 
                        include "koneksi.php";
                        $sql = mysqli_query($koneksi,"select * from produk") or die (mysqli_error($koneksi));
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
                      <input type="number" name="bil2" class="form-control" placeholder="Masukkan jumlah yang dikerjakan">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-8 col-form-label"></label>
                    <div class="col-sm-4">
                      <select class="form-select" aria-label="Default select example" name="operasi">
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
                    <button type="submit" name="hasil" class="btn btn-primary">Simpan</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-printer-fill"></i> Cetak</button>
                  </div>
                </div>

              
              <!-- Table with stripped rows -->
              <table class="table datatable">
                  <?php 
                    // Query untuk mengambil data...
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
                        $data = mysqli_fetch_array($query) ?: ['Harga' => ""]; // Tambahkan pemeriksaan apakah query berhasil dan data ada
                        // Misalkan $harga adalah nilai yang ingin Anda tampilkan dalam format Rupiah
                        $harga = $data["Harga"]; // Contoh nilai harga

                        // Ubah nilai menjadi format Rupiah
                        $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');

                        // Tampilkan nilai dalam format Rupiah
                        // echo $harga_rupiah;

                    }
                  ?>
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Nama Bagian</th>
                    <th scope="col">Jenis Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                      <!-- NAMA KARYAWAN -->
                      <?php 
                        if ($nm_karyawan == "") {
                      ?>
                          <td></td>
                      <?php
                        }else{
                      ?>
                          <td><?= $nm_karyawan; ?></td>
                      <?php
                        }
                      ?>

                      <!-- NAMA BAGIAN -->
                      <?php 
                        if ($nm_bagian == "") {
                      ?>
                          <td></td>
                      <?php
                        }else{
                      ?>
                          <td><?= $nm_bagian; ?></td>
                      <?php
                        }
                      ?>

                      <!-- NAMA PRODUK -->
                      <?php 
                        if ($nm_produk == "") {
                      ?>
                          <td></td>
                      <?php
                        }else{
                      ?>
                          <td><?= $nm_produk; ?></td>
                      <?php
                        }
                      ?>

                      <!-- HARGA -->
                      <td id="bil1" name="bil1"><?= $harga_rupiah; ?></td>

                      <!-- HASIL -->
                      <td><?= $hasil_rupiah;?></td>

                      <td><button type="submit" name="" class="btn btn-danger">Cancel</button></td>

                  </tr>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
            
          </div>
          </form><!-- End General Form Elements -->
        </div>
      </div>
    </section>

  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include "template/footer.php"; ?>
<!-- End Footer -->