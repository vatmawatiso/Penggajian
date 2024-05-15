<?php

// $koneksi = mysqli_connect("localhost","root","","gajian") 
// or die(mysqli_connect_error());

$databaseHost = 'localhost';
$databaseName = 'gajian';
$databaseUsername = 'root';
$databasePassword = '';

$koneksi = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

?>