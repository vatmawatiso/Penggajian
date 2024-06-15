<?php
include 'koneksi.php';

if (isset($_GET['nm_karyawan']) && isset($_GET['tanggal_gajian'])) {
    $nm_karyawan = urldecode($_GET['nm_karyawan']);
    $tanggal_gajian = $_GET['tanggal_gajian'];

    // Hapus laporan berdasarkan nm_karyawan dan tanggal_gajian
    $query = "DELETE FROM laporan WHERE nm_karyawan = '$nm_karyawan' AND tanggal_gajian = '$tanggal_gajian'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Laporan berhasil dihapus.'); window.location.href='laporan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus laporan.'); window.location.href='laporan.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak lengkap.'); window.location.href='index.php';</script>";
}
?>
