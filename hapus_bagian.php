<?php 
session_start();

require 'function.php';

$id_bagian = $_GET["id"];

// Set status penghapusan untuk digunakan sebagai alert
if (hapusBagian($id_bagian) > 0) {
    header("Location: input_bagian.php?delete_status=success");
} else {
    header("Location: input_bagian.php?delete_status=error");
}

?>