<?php
include 'koneksi.php';

$id = $_GET['id'];

// Pastikan $conn sudah diinisialisasi
if (!isset($koneksi)) {
    die("Koneksi ke database gagal!");
}

// Query untuk delete data
$sql = "DELETE FROM konsumen WHERE id_konsumen='$id'";
$query = mysqli_query($koneksi, $sql);

// Set status penghapusan untuk digunakan sebagai alert
if ($query) {
    header("Location: data_konsumenLama.php?delete_status=success");
} else {
    header("Location: data_konsumenLama.php?delete_status=error");
}
?>
