<?php 
  
    // mmebuat koneksi ke db
    $databaseHost = 'localhost';
    $databaseName = 'gajian';
    $databaseUsername = 'root';
    $databasePassword = '';

    $conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
   
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "UPDATE `konsumen` SET `proses`='1' WHERE id_konsumen='$id'"; 
        $query = mysqli_query($conn, $sql);

        if ($query) {
            header('location: data_konsumenLama.php?status=success');
        } else {
            header('location: data_konsumenLama.php?status=error');
        }
    } else {
        header('location: data_konsumenLama.php?status=error');
    }
?>
