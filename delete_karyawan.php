<?php
include 'koneksi.php';

$id = $_GET['id'];

// Pastikan $conn sudah diinisialisasi
if (!isset($koneksi)) {
    die("Koneksi ke database gagal!");
}

// Query untuk delete data
$sql = "DELETE FROM karyawan WHERE id_karyawan='$id'";
$query = mysqli_query($koneksi, $sql);

// Set status penghapusan untuk digunakan sebagai alert
if ($query) {
    header("Location: karyawan_lama.php?delete_status=success");
} else {
    header("Location: karyawan_lama.php?delete_status=error");
}
?>
