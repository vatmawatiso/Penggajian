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

    $nama_karyawan = $data['nama_karyawan'];
    $NIK = $data['NIK'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $nomer_hp = $data['nomer_hp'];
    $alamat = $data['alamat'];
    $jabatan = $data['jabatan'];
    $thn_masuk = $data['thn_masuk'];
    $no_rek = $data['no_rek'];
    $bank = $data['bank'];
    $status = isset($data['status']) ? $data['status'] : '1';

    // Cek apakah NIK sudah ada di database
    $cekNIKQuery = "SELECT COUNT(*) as count FROM karyawan WHERE NIK = '$NIK'";
    $cekNIKResult = mysqli_query($conn, $cekNIKQuery);
    $cekNIKRow = mysqli_fetch_assoc($cekNIKResult);

    if ($cekNIKRow['count'] > 0) {
        return array('success' => false, 'message' => 'NIK sudah ada.');
    }

    $sql = "INSERT INTO karyawan(nama_karyawan, NIK, jenis_kelamin, nomer_hp, alamat, jabatan, thn_masuk, no_rek, bank, status) 
            VALUES ('$nama_karyawan', '$NIK', '$jenis_kelamin', '$nomer_hp', '$alamat', '$jabatan', '$thn_masuk','$no_rek','$bank', '$status')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return array('success' => true, 'message' => 'Data berhasil ditambahkan.');
    } else {
        return array('success' => false, 'message' => 'Terjadi kesalahan saat menambahkan data.');
    }

        // return $query ? mysqli_affected_rows($conn) : -1;
}


//FUNGSI UPDATE DATA KARYAWAN
function updateKaryawan($data) {
    global $conn;

    $id = $data['id_karyawan'];
    $nama_karyawan = $data['nama_karyawan'];
    $NIK = htmlspecialchars($data['NIK']);
    $jenis_kelamin = $data['jenis_kelamin'];
    $nomer_hp = $data['nomer_hp'];
    $alamat = $data['alamat'];
    $jabatan = $data['jabatan'];
    $thn_masuk = $data['thn_masuk'];
    $no_rek = $data['no_rek'];
    $bank = $data['bank'];
    $source = strtolower(stripslashes($data["source"]));

    // Cek apakah NIK sudah ada di database
    $cekNIKQuery = "SELECT COUNT(*) as count FROM karyawan WHERE NIK = '$NIK' AND id_karyawan!='$id'";
    $cekNIKResult = mysqli_query($conn, $cekNIKQuery);
    $cekNIKRow = mysqli_fetch_assoc($cekNIKResult);

    if ($cekNIKRow['count'] > 0) {
        return array('success' => false, 'message' => 'NIK sudah ada.');
    }else{
        $sql = "UPDATE karyawan SET 
                nama_karyawan='$nama_karyawan', 
                NIK='$NIK', 
                jenis_kelamin='$jenis_kelamin', 
                nomer_hp='$nomer_hp', 
                alamat='$alamat', 
                jabatan='$jabatan', 
                thn_masuk='$thn_masuk',
                no_rek='$no_rek',
                bank='$bank' 
                WHERE id_karyawan='$id'";
                $query = mysqli_query($conn, $sql);

                if ($query) {
                return array('success' => true, 'message' => 'Data berhasil ditambahkan.');
                } else {
                return array('success' => false, 'message' => 'Terjadi kesalahan saat menambahkan data.');
                }
    }

    // return $query ? mysqli_affected_rows($conn) : -1;
}

//FUNGSI UPDATE STATUS KARYAWAN BARU
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

// FUNGSI INSERT DATA PRODUK
function insertProduk($data)
{
    global $conn;

    $nama_produk = strtolower(stripslashes($data["nama_produk"]));
    $deskripsi_produk = strtolower(stripslashes($data["deskripsi_produk"]));

    // Cek apakah produk sudah ada di database
    $cekProdukQuery = "SELECT COUNT(*) as count FROM produk WHERE nama_produk = '$nama_produk'";
    $cekProdukResult = mysqli_query($conn, $cekProdukQuery);
    $cekProdukRow = mysqli_fetch_assoc($cekProdukResult);

    if ($cekProdukRow['count'] > 0) {
        return array('success' => false, 'message' => 'Produk sudah ada.');
    }

    // Periksa apakah file gambar diunggah
    if (!isset($_FILES["foto_produk"])) {
        return array('success' => false, 'message' => 'Tidak ada file gambar yang diunggah.');
    }

    $foto_produk = $_FILES["foto_produk"];

    // Proses upload gambar
    // $targetDir = "uploads/";
    $targetDir = "assets/img/";
    $targetFile = $targetDir . basename($foto_produk["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Cek apakah file gambar adalah gambar asli atau bukan
    $check = getimagesize($foto_produk["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        return array('success' => false, 'message' => 'File yang diunggah bukan gambar.');
        $uploadOk = 0;
    }

    // Cek jika file sudah ada
    if (file_exists($targetFile)) {
        return array('success' => false, 'message' => 'File gambar sudah ada.');
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($foto_produk["size"] > 500000) {
        return array('success' => false, 'message' => 'Ukuran file gambar terlalu besar.');
        $uploadOk = 0;
    }

    // Batasi tipe file yang diperbolehkan
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return array('success' => false, 'message' => 'Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.');
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0
    if ($uploadOk == 0) {
        return array('success' => false, 'message' => 'Gagal mengunggah file gambar.');
    } else {
        if (move_uploaded_file($foto_produk["tmp_name"], $targetFile)) {
            // File berhasil diunggah, lanjutkan menyimpan data ke database
            $sql = "INSERT INTO produk (nama_produk, deskripsi_produk, foto_produk) VALUES ('$nama_produk', '$deskripsi_produk', '$targetFile')";
            $query = mysqli_query($conn, $sql);

            if ($query) {
                return array('success' => true, 'message' => 'Data produk berhasil ditambahkan.');
            } else {
                return array('success' => false, 'message' => 'Terjadi kesalahan saat menambahkan data produk.');
            }
        } else {
            return array('success' => false, 'message' => 'Terjadi kesalahan saat mengunggah file gambar.');
        }
    }
}


//FUNGSI UPDATE DATA PRODUK
function updateProduk($data)
{
    global $conn;

    $id_produk = $data["id_produk"];
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $deskripsi_produk = htmlspecialchars($data["deskripsi_produk"]);

    // Cek apakah produk sudah ada di database
    $cekProdukQuery = "SELECT COUNT(*) as count FROM produk WHERE nama_produk = '$nama_produk' AND id_produk != '$id_produk'";
    $cekProdukResult = mysqli_query($conn, $cekProdukQuery);
    $cekProdukRow = mysqli_fetch_assoc($cekProdukResult);

    if ($cekProdukRow['count'] > 0) {
        return array('success' => false, 'message' => 'Produk sudah ada.');
    }

    $uploadOk = 1;
    $newFileName = '';

    // Periksa apakah file gambar diunggah
    if (isset($_FILES["foto_produk"]) && $_FILES["foto_produk"]["error"] == 0) {
        $foto_produk = $_FILES["foto_produk"];

        // Proses upload gambar
        $targetDir = "assets/img/";
        $imageFileType = strtolower(pathinfo($foto_produk["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType; // Generate unique file name
        $targetFile = $targetDir . $newFileName;

        // Cek apakah file gambar adalah gambar asli atau bukan
        $check = getimagesize($foto_produk["tmp_name"]);
        if ($check === false) {
            return array('success' => false, 'message' => 'File yang diunggah bukan gambar.');
        }

        // Cek ukuran file
        if ($foto_produk["size"] > 500000) {
            return array('success' => false, 'message' => 'Ukuran file gambar terlalu besar.');
        }

        // Batasi tipe file yang diperbolehkan
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return array('success' => false, 'message' => 'Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.');
        }

        // Cek jika $uploadOk bernilai 0
        if ($uploadOk == 0) {
            return array('success' => false, 'message' => 'Gagal mengunggah file gambar.');
        } else {
            if (!move_uploaded_file($foto_produk["tmp_name"], $targetFile)) {
                return array('success' => false, 'message' => 'Terjadi kesalahan saat mengunggah file gambar.');
            }
        }
    }

    // query edit data
    if ($newFileName) {
        $sql = "UPDATE produk SET
                nama_produk = '$nama_produk',
                deskripsi_produk = '$deskripsi_produk',
                foto_produk = '$newFileName'
                WHERE id_produk = $id_produk";
    } else {
        $sql = "UPDATE produk SET
                nama_produk = '$nama_produk',
                deskripsi_produk = '$deskripsi_produk'
                WHERE id_produk = $id_produk";
    }

    $query = mysqli_query($conn, $sql);

    if ($query) {
        return array('success' => true, 'message' => 'Data produk berhasil diubah.');
    } else {
        return array('success' => false, 'message' => 'Terjadi kesalahan saat mengubah data produk.');
    }
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

    // Cek apakah bagian sudah ada di database
    $cekBagianQuery = "SELECT COUNT(*) as count FROM bagian WHERE nama_bagian = '$nama_bagian'";
    $cekBagianResult = mysqli_query($conn, $cekBagianQuery);
    $cekBagianRow = mysqli_fetch_assoc($cekBagianResult);

    if ($cekBagianRow['count'] > 0) {
        // Jika bagian sudah ada, kembalikan nilai -1 sebagai indikasi gagal
        // return -1;
        return array('success' => false, 'message' => 'Bagian sudah ada.');
    }

    // Insert user data into table
    $sql = "INSERT INTO bagian (nama_bagian) VALUES ('$nama_bagian')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return array('success' => true, 'message' => 'Data bagian berhasil ditambahkan.');
    } else {
        return array('success' => false, 'message' => 'Terjadi kesalahan saat menambahkan data bagian.');
    }

    // return mysqli_affected_rows($conn);
}

//FUNGSI UPDATE DATA BAGIAN
function updateBagian($data)
{
    global $conn;

	$id_bagian = $data["id_bagian"];
	$nama_bagian = htmlspecialchars($data["nama_bagian"]);

    // Cek apakah bagian sudah ada di database
    $cekBagianQuery = "SELECT COUNT(*) as count FROM bagian WHERE nama_bagian = '$nama_bagian' AND id_bagian != '$id_bagian'";
    $cekBagianResult = mysqli_query($conn, $cekBagianQuery);
    $cekBagianRow = mysqli_fetch_assoc($cekBagianResult);

    if ($cekBagianRow['count'] > 0) {
        // Jika bagian sudah ada, kembalikan nilai -1 sebagai indikasi gagal
        // return -1;
        return array('success' => false, 'message' => 'Bagian sudah ada.');
    }

	//query edit data
    $sql = "UPDATE bagian
            SET nama_bagian = '$nama_bagian'
            WHERE id_bagian = '$id_bagian';
            ";
   
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return array('success' => true, 'message' => 'Data bagian berhasil di ubah.');
    } else {
        return array('success' => false, 'message' => 'Terjadi kesalahan saat mengubah data bagian.');
    }

    // return mysqli_affected_rows($conn);

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

    $id_harga = $data["id_harga"];
    $id_bagian = strtolower(stripslashes($data["id_bagian"]));
    $id_produk = strtolower(stripslashes($data["id_produk"]));
    $harga = strtolower(stripslashes($data["harga"]));

    // Cek apakah kombinasi id_produk dan id_bagian sudah ada di database
    $cekHargaQuery = "SELECT COUNT(*) as count FROM harga WHERE id_produk = '$id_produk' AND id_bagian = '$id_bagian' AND id_harga != '$id_harga'";
    $cekHargaResult = mysqli_query($conn, $cekHargaQuery);
    $cekHargaRow = mysqli_fetch_assoc($cekHargaResult);

    if ($cekHargaRow['count'] > 0) {
        // Jika sudah ada, kembalikan nilai -1 sebagai indikasi gagal
        return -1;
    }

    // Insert data harga ke dalam tabel
    $sql = "INSERT INTO harga (id_produk, id_bagian, harga) VALUES ('$id_produk', '$id_bagian', '$harga')";
    $query = mysqli_query($conn, $sql);

    return $query ? mysqli_affected_rows($conn) : -1;
}

//FUNGSI UPDATE DATA HARGA PRODUK DAN BAGIAN
function updateHarga($data)
{
    global $conn;

    $id_harga = $data["id_harga"];
    $id_produk = $data["id_produk"];
    $id_bagian = $data["id_bagian"];
    $harga = strtolower(stripslashes($data["harga"]));

    // Cek apakah kombinasi id_produk dan id_bagian sudah ada di database
    $cekHargaQuery = "SELECT COUNT(*) as count FROM harga WHERE id_produk = '$id_produk' AND id_bagian = '$id_bagian' AND id_harga != '$id_harga'";
    $cekHargaResult = mysqli_query($conn, $cekHargaQuery);
    $cekHargaRow = mysqli_fetch_assoc($cekHargaResult);

    if ($cekHargaRow['count'] > 0) {
        // Jika bagian sudah ada, kembalikan nilai -1 sebagai indikasi gagal
        // return -1;
        return array('success' => false, 'message' => 'Harga sudah ada.');
    }

    //query edit data
    $sql = "UPDATE harga SET id_produk = '$id_produk', id_bagian = '$id_bagian', harga = '$harga' WHERE id_harga = '$id_harga'";

    $query = mysqli_query($conn, $sql);

    return $query ? mysqli_affected_rows($conn) : -1;

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
function insertKonsumen($data)
{
    global $conn;

    $nama_konsumen = $data['nama_konsumen'];
    $perusahaan = $data['perusahaan'];
    $telepon = $data['telepon'];
    $alamat = $data['alamat'];
    $proses = isset($data['proses']) ? $data['proses'] : '1';
    // $proses = $data['proses'];

    // include database connection file
    include_once("koneksi.php");

    // Insert user data into table
    $sql = "INSERT INTO konsumen( nama_konsumen, perusahaan, telepon, alamat, proses) 
            VALUES ('$nama_konsumen','$perusahaan','$telepon','$alamat', '$proses')";

    $query = mysqli_query($conn, $sql);

    return $query ? mysqli_affected_rows($conn) : -1;

}

//FUNGSI UPDATE DATA KARYAWAN
function updateKonsumen($data)
{

    global $conn;

    $id = $data['id_konsumen'];
    $nama_konsumen = $data['nama_konsumen'];
    $perusahaan = $data['perusahaan'];
    $telepon = $data['telepon'];
    $alamat = $data['alamat'];
    $source = strtolower(stripslashes($data["source"])); // Mengambil parameter source dari URL

    // var_dump('isi => ', $source);
    // die();

    $sql = "UPDATE konsumen SET nama_konsumen='$nama_konsumen', perusahaan='$perusahaan', telepon='$telepon', alamat='$alamat' WHERE id_konsumen='$id'";
    $query = mysqli_query($conn, $sql);

    return $query ? mysqli_affected_rows($conn) : -1;
}

?>