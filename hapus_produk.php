<?php 
session_start();

require 'function.php';

$id_produk = $_GET["id"];

// Set status penghapusan untuk digunakan sebagai alert
if (hapusProduk($id_produk) > 0) {
    header("Location: input_produk.php?delete_status=success");
} else {
    header("Location: input_produk.php?delete_status=error");
}

?>