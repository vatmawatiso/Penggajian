<?php 
  
    // mmebuat koneksi ke db
    $databaseHost = 'localhost';
    $databaseName = 'gajian';
    $databaseUsername = 'root';
    $databasePassword = '';

    $conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    if (isset($_GET['id'])){ 
        $id = $_GET['id'];
        $sql = "UPDATE karyawan SET status='0' WHERE id_karyawan='$id'";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            header('location: karyawan_baru.php?status=success');
        } else {
            header('location: karyawan_baru.php?status=error');
        }
    } else {
        header('location: karyawan_baru.php?status=error');
    }
?>
