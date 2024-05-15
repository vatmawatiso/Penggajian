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
function insertKaryawan()
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
    $sql = "INSERT INTO karyawan(nama_karyawan, NIK, jenis_kelamin, nomer_hp, alamat, jabatan, thn_masuk, status) VALUES ('$nama_karyawan', '$NIK', '$jenis_kelamin', '$nomer_hp', '$alamat', '$jabatan', '$thn_masuk', 'Aktif')";
    $query = mysqli_query($conn, $sql);
        // apakah query update berhasil?
        if ($query) {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header("Location: karyawan_baru.php");
        } else {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }

    // Show message when user added
    echo "<script>alert('Tambah data karyawan berhasil')</script>";
}

//FUNGSI UPDATE DATA KARYAWAN
function updateKaryawan()
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

    $sql = "UPDATE karyawan SET nama_karyawan='$nama_karyawan', NIK='$NIK', jenis_kelamin='$jenis_kelamin', nomer_hp='$nomer_hp', alamat='$alamat', jabatan='$jabatan', thn_masuk='$thn_masuk' WHERE id_karyawan='$id'";
    $query = mysqli_query($conn, $sql);
    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header("Location: karyawan_baru.php");
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

            header('Location: index.php');
        } else {
            echo '<script>alert("your password is invalid!")</script>';
        }
    } else {
        echo '<script>alert("Your account not exists!")</script>';
    }
}

//FUNGSI UPDATE AKUN
function updateAkun()
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



?>