<?php 
session_start();

require 'function.php';

$id_harga = $_GET["id"];

if( hapusHarga($id_harga) > 0){
	echo "
			<script>
				alert('Data berhasil dihapus!');
				document.location.href ='input_harga.php';
			</script>
		";
} else {
	echo "
			<script>
				alert('Data gagal dihapus!');
				document.location.href ='input_harga.php';
			</script>
		";
}

?>