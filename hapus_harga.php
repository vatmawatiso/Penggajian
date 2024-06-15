<?php 
session_start();

require 'function.php';

$id_harga = $_GET["id"];

// Set status penghapusan untuk digunakan sebagai alert
if (hapusHarga($id_harga) > 0) {
    header("Location: input_harga.php?delete_status=success");
} else {
    header("Location: input_harga.php?delete_status=error");
}

?>