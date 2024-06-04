<?php 
session_start();

require 'function.php';

$id_produk = $_GET["id"];

if( hapusProduk($id_produk) > 0){
	echo "
			<script>
				alert('Data berhasil dihapus!');
				document.location.href ='input_produk.php';
			</script>
		";
} else {
	echo "
			<script>
				alert('Data gagal dihapus!');
				document.location.href ='input_produk.php';
			</script>
		";
}

?>