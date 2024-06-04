<?php 
  
    // mmebuat koneksi ke db
    $databaseHost = 'localhost';
    $databaseName = 'gajian';
    $databaseUsername = 'root';
    $databasePassword = '';

    $conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    if (isset($_GET['id'])){ 
  
        $id = $_GET['id'];
   
        $sql="UPDATE karyawan SET status='0' WHERE id_karyawan='$id';"; 
  
        // Execute the query 
        mysqli_query($conn,$sql); 

        $sql = "UPDATE karyawan SET status='0' WHERE id_karyawan='$id'";
        $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            echo "Status karyawan berhasil diubah menjadi tidak aktif.";
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }
    } 
  
    // Go back to course-page.php 
    header('location: karyawan_baru.php'); 
?>