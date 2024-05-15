<?php 
  
    // mmebuat koneksi ke db
    $databaseHost = 'localhost';
    $databaseName = 'gajian';
    $databaseUsername = 'root';
    $databasePassword = '';

    $conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
   
    if (isset($_GET['id'])){ 
   
        $id = $_GET['id'];
   
        $sql="UPDATE `karyawan` SET `status`='1' WHERE id_karyawan='$id'"; 
  
        // Execute the query 
        mysqli_query($conn,$sql); 
    } 
  
    // Go back to course-page.php 
    header('location: karyawan_lama.php'); 
?>