<?php

// mmebuat koneksi ke db
$databaseHost = 'localhost';
$databaseName = 'gajian';
$databaseUsername = 'root';
$databasePassword = '';

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//FUNGSI INSERT DATA KARYAWAN
function insertKaryawan($data)
{
    global $conn;

    $nama_karyawan = $_POST['nama_karyawan'];
    $NIK = $_POST['NIK'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomer_hp = $_POST['nomer_hp'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $thn_masuk = $_POST['thn_masuk'];
    $status = $_POST['status'];

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO karyawan(nama_karyawan, NIK, jenis_kelamin, nomer_hp, alamat, jabatan, thn_masuk, status) VALUES ('$nama_karyawan', '$NIK', '$jenis_kelamin', '$nomer_hp', '$alamat', '$jabatan', '$thn_masuk', '1')";
    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header("Location: karyawan_baru.php");
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }
        return mysqli_affected_rows($conn);
}

//FUNGSI UPDATE DATA KARYAWAN
function updateKaryawan($data)
{

    global $conn;

    $id = $_POST['id_karyawan'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $NIK = $_POST['NIK'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomer_hp = $_POST['nomer_hp'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $thn_masuk = $_POST['thn_masuk'];
    $source = strtolower(stripslashes($data["source"])); // Mengambil parameter source dari URL

    // var_dump('isi => ', $source);
    // die();

    $sql = "UPDATE karyawan SET nama_karyawan='$nama_karyawan', NIK='$NIK', jenis_kelamin='$jenis_kelamin', nomer_hp='$nomer_hp', alamat='$alamat', jabatan='$jabatan', thn_masuk='$thn_masuk' WHERE id_karyawan='$id'";
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman sesuai source
        if ($source === 'karyawan_lama') {
            header("Location: karyawan_lama.php");
        } else {
            header("Location: karyawan_baru.php");
        }
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }
}

//FUNGSI UPDATE STATUS KARYAWAN BARU
// Periksa apakah tombol update_status diklik
if (isset($_POST['update_status'])) {
    // Ambil ID karyawan dari formulir
    $id = $_POST['id_karyawan'];
    
    // Query untuk mengupdate status karyawan menjadi tidak aktif
    $query = "UPDATE karyawan SET status = 'tidak aktif' WHERE id = $id_karyawan";
    
    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Status karyawan berhasil diubah menjadi tidak aktif.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    // Tutup koneksi
    mysqli_close($conn);
}

//FUNGSI REGISTRASI
function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah terdaftar!')</script>";

        return false;
    }

    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai')</script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // var_dump($password);
    // die;

    // return 1;
    //Tambahkan user ke database
    mysqli_query($conn, "INSERT INTO akun VALUES ('','$username','$email','$password')");

    return mysqli_affected_rows($conn);
}

//FUNGSI LOGIN
function login($data)
{
    global $conn;

    $id_user = htmlspecialchars($_POST['id_user']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM akun WHERE username='$username'");
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_array($query);
        if (password_verify($password, $data['password'])) {
            //set session
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $data['id_user'];

            header('Location: index.php');
        } else {
            echo '<script>alert("your password is invalid!")</script>';
        }
    } else {
        echo '<script>alert("Your account not exists!")</script>';
    }
}

// //FUNGSI UPDATE AKUN
function updateAkun($data)
{
    global $conn;

    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE akun SET username='$username', email='$email' WHERE id_user='$id'";
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        echo '<script>alert("Profil berhasil di edit!")</script>';
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }
}

//FUNGSI INSERT DATA PRODUK
function insertProduk($data)
{
    global $conn;

    $nama_produk = strtolower(stripslashes($data["nama_produk"]));
    $deskripsi_produk = strtolower(stripslashes($data["deskripsi_produk"]));

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO produk (nama_produk, deskripsi_produk) VALUES ('$nama_produk', '$deskripsi_produk')";
    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header("Location: input_produk.php");
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }

    // Show message when user added
    echo "<script>alert('Tambah data produk berhasil')</script>";
}

//FUNGSI UPDATE DATA PRODUK
function updateProduk($data)
{

    global $conn;

	$id_produk = $data["id_produk"];
	$nama_produk = htmlspecialchars($data["nama_produk"]);
	$deskripsi_produk = htmlspecialchars($data["deskripsi_produk"]);

	//query edit data
	$sql = "UPDATE produk SET
				nama_produk = '$nama_produk', 
				deskripsi_produk = '$deskripsi_produk'
				WHERE id_produk = $id_produk
			";
   
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header("Location: input_produk.php");
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }
    return mysqli_affected_rows($conn);
}

//FUNGSI HAPUS DATA PRODUK
function hapusProduk($id_produk) {
	global $conn;

	mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id_produk");

	return mysqli_affected_rows($conn);
}

//FUNGSI INSERT DATA BAGIAN
function insertBagian($data)
{
    global $conn;

    $nama_bagian = strtolower(stripslashes($data["nama_bagian"]));

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO bagian (nama_bagian) VALUES ('$nama_bagian')";
    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header("Location: input_produk.php");
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }

    // Show message when user added
    echo "<script>alert('Tambah data produk berhasil')</script>";
}

//FUNGSI UPDATE DATA BAGIAN
function updateBagian($data)
{
    global $conn;

	$id_bagian = $data["id_bagian"];
	$nama_bagian = htmlspecialchars($data["nama_bagian"]);

	//query edit data
    $sql = "UPDATE bagian
            SET nama_bagian = '$nama_bagian'
            WHERE id_bagian = '$id_bagian';
            ";
   
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header("Location: input_bagian.php");
    } else {
        // kalau gagal tampilkan pesan
        // die("Gagal menyimpan perubahan...");
        echo mysqli_error($conn);
    }
    return mysqli_affected_rows($conn);

}

//FUNGSI HAPUS DATA BAGIAN
function hapusBagian($id_bagian) {
	global $conn;

	mysqli_query($conn, "DELETE FROM bagian WHERE id_bagian = $id_bagian");

	return mysqli_affected_rows($conn);
}

//FUNGSI INSERT DATA HARGA PRODUK DAN BAGIAN
function insertHarga($data)
{
    global $conn;

    $id_bagian = strtolower(stripslashes($data["id_bagian"]));
    $id_produk = strtolower(stripslashes($data["id_produk"]));
    $harga = strtolower(stripslashes($data["harga"]));

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO harga (id_produk, id_bagian, harga) VALUES ('$id_produk', '$id_bagian', '$harga')";
    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header("Location: input_harga.php");
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }

    // Show message when user added
    echo "<script>alert('Tambah data produk berhasil')</script>";

    return mysqli_affected_rows($conn);
}

//FUNGSI UPDATE DATA HARGA PRODUK DAN BAGIAN
function updateHarga($data)
{
    global $conn;

    $id_harga = $data["id_harga"];
    $id_produk = $data["id_produk"];
    $id_bagian = $data["id_bagian"];
    $harga = strtolower(stripslashes($data["harga"]));

    // var_dump($id_produk);
    // var_dump($id_bagian);
    // var_dump($harga);
    // var_dump($id_harga);
    // die();

	//query edit data
    $sql = "UPDATE harga
            SET id_produk = '$id_produk',
                id_bagian = '$id_bagian',
                harga = '$harga'
            WHERE id_harga = '$id_harga';
            ";

            // var_dump($sql);
   
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header("Location: input_harga.php");
    } else {
        // kalau gagal tampilkan pesan
        // die("Gagal menyimpan perubahan...");
        echo mysqli_error($conn);
    }
    return mysqli_affected_rows($conn);

}

//FUNGSI HAPUS DATA HARGA
function hapusHarga($id_harga) {
	global $conn;

	mysqli_query($conn, "DELETE FROM harga WHERE id_harga = $id_harga");

	return mysqli_affected_rows($conn);
}

//FUNGSI LUPA PASSWORD / KONFIRMASI EMAIL
function konfirmEmail()
{

    global $conn;

    $email = $_POST['email']; // Ambil email dari form

    $sql = "SELECT * FROM akun WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email sudah terdaftar dalam database
        $_SESSION['email'] = $email;

        echo "<script>alert('Email yang dimasukkan benar');window.location.href='update_password.php';</script>";
    } else {
        // Email belum terdaftar dalam database
        echo "<script>alert('Email yang dimasukkan salah')</script>";
    }

    // Tutup koneksi ke database
    $conn->close();
}

// //FUNGSI INSERT DATA KONSUMEN
function insertKonsumen()
{
    global $conn;

    $nama_konsumen = $_POST['nama_konsumen'];
    $perusahaan = $_POST['perusahaan'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $proses = $_POST['proses'];

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO konsumen( nama_konsumen, perusahaan, telepon, alamat, proses) VALUES ('$nama_konsumen','$perusahaan','$telepon','$alamat', '1')";

    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            echo 'Tambah data karyawan berhasil';
            header("Location: data_konsumenBaru.php");
        } else {
            // kalau gagal tampilkan pesan
            echo mysqli_error($conn);
            die();
        }
        return mysqli_affected_rows($conn);
}

//FUNGSI UPDATE DATA KARYAWAN
function updateKonsumen($data)
{

    global $conn;

    $id = $_POST['id_konsumen'];
    $nama_konsumen = $_POST['nama_konsumen'];
    $perusahaan = $_POST['perusahaan'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $source = strtolower(stripslashes($data["source"])); // Mengambil parameter source dari URL

    // var_dump('isi => ', $source);
    // die();

    $sql = "UPDATE konsumen SET nama_konsumen='$nama_konsumen', perusahaan='$perusahaan', telepon='$telepon', alamat='$alamat' WHERE id_konsumen='$id'";
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman sesuai source
        if ($source === 'konsumen_lama') {
            header("Location: data_konsumenLama.php");
        } else {
            header("Location: data_konsumenBaru.php");
        }
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }
}








?>