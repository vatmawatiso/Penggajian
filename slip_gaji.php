<?php
require_once __DIR__ . '/mpdf_v8.0.3-master/vendor/autoload.php';
session_start();
include_once("koneksi.php");

use Mpdf\Mpdf;

// Sample data from session (replace this with your session data)
$data_gaji = $_SESSION['data_gaji'] ?? [];
$subtotal_rupiah = $_SESSION['subtotal'] ?? 'Rp 0';
$data_kry = $_SESSION['DETAIL'];

// Initialize mPDF for A4 size
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => 10,
    'default_font' => 'Arial'
]);

// Fungsi untuk mengambil nomor nota terakhir dari penyimpanan, jika tersedia
function getLastNotaNumber() {
    // Misalnya, Anda dapat menyimpan nomor nota terakhir di dalam session
    // Anda bisa menyesuaikan metode penyimpanan ini sesuai kebutuhan aplikasi Anda
    return $_SESSION['lastNotaNumber'] ?? 0;
}

// Fungsi untuk mengupdate nomor nota terakhir setelah pencetakan
function updateLastNotaNumber($nextNotaNumber) {
    // Simpan nomor nota terakhir kembali ke penyimpanan
    // Misalnya, Anda bisa menyimpannya kembali ke dalam session
    // Anda bisa menyesuaikan metode penyimpanan ini sesuai kebutuhan aplikasi Anda
    $_SESSION['lastNotaNumber'] = $nextNotaNumber;
}

// Fungsi untuk menghasilkan nomor nota berikutnya
function generateNotaNumber($lastNotaNumber) {
    // Tambahkan 1 ke nomor nota terakhir untuk mendapatkan nomor nota berikutnya
    $nextNotaNumber = $lastNotaNumber + 1;
    return $nextNotaNumber;
}

// Dapatkan nomor nota terakhir
$lastNotaNumber = getLastNotaNumber();

// Dapatkan nomor nota berikutnya
$nextNotaNumber = generateNotaNumber($lastNotaNumber);

// Format nomor nota dengan prefix "AR/" dan tambahkan leading zero jika perlu
$notaNumber = str_pad($nextNotaNumber, 4, '0', STR_PAD_LEFT);

// Simpan nomor nota terbaru
updateLastNotaNumber($nextNotaNumber);

// Outputkan nomor nota
echo $notaNumber; // Contoh output: AR/1001

// Simpan $notaNumber ke dalam tabel laporan
$nm_karyawan = $data_kry['nm_karyawan'];
$tanggal_gajian = $data_kry['tanggal_gajian'];

// Cek apakah data dengan nm_karyawan dan tanggal_gajian sudah ada di tabel laporan
$queryCheck = "SELECT COUNT(*) AS count FROM laporan WHERE nm_karyawan = '$nm_karyawan' AND tanggal_gajian = '$tanggal_gajian'";
$resultCheck = mysqli_query($koneksi, $queryCheck);

if (!$resultCheck) {
    echo "Error checking existing data in database: " . mysqli_error($koneksi);
    exit;
}

$row = mysqli_fetch_assoc($resultCheck);
$count = $row['count'];

if ($count > 0) {
    // Jika data sudah ada, lakukan update nota_number
    $queryUpdate = "UPDATE laporan SET nota_number = '$notaNumber' WHERE nm_karyawan = '$nm_karyawan' AND tanggal_gajian = '$tanggal_gajian'";
    
    if (!mysqli_query($koneksi, $queryUpdate)) {
        echo "Error updating nota number into database: " . mysqli_error($koneksi);
        exit;
    }
} else {
    // Jika data belum ada, lakukan insert baru
    $queryInsert = "INSERT INTO laporan (nm_karyawan, tanggal_gajian, nota_number) VALUES ('$nm_karyawan', '$tanggal_gajian', '$notaNumber')";
    
    if (!mysqli_query($koneksi, $queryInsert)) {
        echo "Error inserting nota number into database: " . mysqli_error($koneksi);
        exit;
    }
}



function formatTanggalIndonesia() {
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
  
    $hariIndo = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
  
    // Konversi tanggal sekarang menjadi timestamp menggunakan time()
    $date = time();
    // Dapatkan nama hari dalam bahasa Indonesia
    $hari = $hariIndo[date('l', $date)];
    // Dapatkan tanggal
    $tanggal = date('d', $date);
    // Dapatkan bulan dalam bahasa Indonesia
    $bulan = $bulanIndo[(int)date('m', $date)];
    // Dapatkan tahun
    $tahun = date('Y', $date);
  
    return "$hari, $tanggal $bulan $tahun";
}

// Simpan hasilnya ke dalam variabel
$tanggalIndonesia = formatTanggalIndonesia();

// Tampilkan hasilnya
echo $tanggalIndonesia;


// Assuming that $data_gaji contains multiple entries for the same employee
if (!empty($data_gaji)) {
    // Get the common employee details from the first entry
    $common_details = $data_gaji[0];

    // Create the HTML content
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Slip Gaji Karyawan</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 10pt; }
            .header { text-align: center; margin-bottom: 10mm; }
            .header h1 { margin: 0; font-size: 14pt; }
            .header p { margin: 0; }
            .header h2 { margin: 5mm 0; font-size: 12pt; }
            .table { width: 100%; border-collapse: collapse; margin-bottom: 10mm; }
            .table th, .table td { border: 1px solid #000; padding: 5px; text-align: left; }
            .table th { background-color: #f2f2f2; }
            .right { text-align: right; }
            .footer { text-align: right; margin-top: 10mm; }
            .no-border { border: none; }
            .left { text-align: left; }
            .total-row { display: flex; justify-content: space-between; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>ADITYA ROTAN</h1>
            <p>Jl. BAP 1, Desa Pamijahan, Blok Kijad, RT/RW 009/002, Kec. Plumbon Kab. Cirebon, 45155<br>Telp: 089 613 112 073</p>
            <h2>SLIP GAJI KARYAWAN</h2>
            <table style="width: 100%;">
                 <tr>
                    <td style="width: 5%;">Tanggal    </td>
                    <td style="width: 70%;">: ' . $tanggalIndonesia . '</td> 
                </tr>
                <tr>
                    <td style="width: 5%;">No.      </td>
                    <td style="width: 70%;">: ' . $notaNumber . '</td>
                </tr>
                <tr>
                    <td style="width: 5%;">Nama   </td>
                    <td style="width: 70%;">: ' . htmlspecialchars($common_details['nm_karyawan']) . '</td>
                </tr>
                <tr>
                    <td style="width: 5%;">Bagian        </td>
                    <td style="width: 70%;">: ' . htmlspecialchars($common_details['bagian']) . '</td>
                </tr>
            </table>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Nama Produk</th>
                    <th style="text-align: center;">QTY</th>
                    <th style="text-align: center; border-right: none; width: 50px;"></th>
                    <th style="center; border-left: none; border-bottom: none;">Harga</th>
                    <th style="text-align: center; border-right: none;  width: 50px;"></th>
                    <th style="border-left: border-left: none; border-bottom: none; width: 100px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>';

    $last_bagian = null;
    foreach ($data_gaji as $index => $gaji) {
        $bagian_name = $gaji['bagian'] === $last_bagian ? '' : htmlspecialchars($gaji['bagian']);
        $html .= '
        <tr>
            <td style="text-align: center;">' . ($index + 1) . '</td>
            <td>' . htmlspecialchars($gaji['produk']) . '</td>
            <td class="right" style="text-align: right;" style="text-align: center;">' . htmlspecialchars($gaji['jumlah']) . '</td>
            <td style="border-right: none; width: 5px;">Rp </td>
            <td class="right" style="text-align: right; border-left: none;">' . htmlspecialchars($gaji['harga']) . '</td>
            <td style="border-right: none; width: 5px;">Rp</td>
            <td class="right" style="text-align: right; border-left: none; border-bottom: none;">' . htmlspecialchars($gaji['total']) . '</td>
        </tr>';
        $last_bagian = $gaji['bagian'];
    }

    $html .= '
        <tr>
            <td colspan="5" class="right" style="text-align: right; border: none;"><strong>Total:</strong></td>
            <td style="border-right: none; width: 5px;">Rp</td>
            <td class="right" style="text-align: right; border-left: none;"><strong>' . htmlspecialchars($subtotal_rupiah) . '</strong></td>
        </tr>
        </tbody>
    </table>

    <div style="display: flex; justify-content: space-between; padding: 20px; align-items: flex-start;">
        <div style="width: 60%; text-align: right;">
            <p>Tanda Terima,</p>
            <p></p>
            <p></p>
            <p>(...................)</p>
        </div>
        <div style="width: 100%; text-align: right; margin-top: -110px;"> <!-- Adjust margin-top as needed -->
            <p>Hormat Kami,</p>
            <p></p>
            <p></p>
            <p>(...................)</p>
            <p>Lili Rahayu</p>
            <p>(Admin)</p>
        </div>
    </div>
    </body>
    </html>';

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Output the PDF to the browser
    $mpdf->Output('Slip_Gaji_Karyawan_' . htmlspecialchars($common_details['nm_karyawan']) . '.pdf', \Mpdf\Output\Destination::INLINE);
}
?>
