<?php 
session_start();

require 'function.php';

$id_bagian = $_GET["id"];

if( hapusBagian($id_bagian) > 0){
	echo "
			<script>
				alert('Data berhasil dihapus!');
				document.location.href ='input_bagian.php';
			</script>
		";
} else {
	echo "
			<script>
				alert('Data gagal dihapus!');
				document.location.href ='input_bagian.php';
			</script>
		";
}

?>