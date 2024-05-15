<?php

include 'koneksi.php';

$id = $_GET['id'];
//query untuk delete data
$sql = "DELETE FROM karyawan WHERE id_karyawan='$id'";
//setelah data dihapus redirect ke halaman tampil.php
$query = mysqli_query($conn, $sql);
// apakah query update berhasil?
if ($query) {
    // kalau berhasil alihkan ke halaman list-siswa.php
    echo "Data karyawan berhasil dihapus";
} else {
    // kalau gagal tampilkan pesan
    die("Gagal menyimpan perubahan...");
}