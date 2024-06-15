<?php
session_start();
require_once __DIR__ . '/mpdf_v8.0.3-master/vendor/autoload.php';
include_once("koneksi.php");

use Mpdf\Mpdf;

if (!isset($_GET['nm_karyawan']) || !isset($_GET['tanggal_gajian'])) {
    echo "Invalid parameters!";
    exit;
}

$nm_karyawan = urldecode($_GET['nm_karyawan']);
$tanggal_gajian = $_GET['tanggal_gajian'];

// Fetch data from database
$data_gaji = [];
$query = "SELECT nm_karyawan, bagian, produk, jumlah, harga, total, nota_number
          FROM laporan 
          WHERE nm_karyawan = '$nm_karyawan' AND tanggal_gajian = '$tanggal_gajian'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Error executing query: " . mysqli_error($koneksi);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $data_gaji[] = $row;
}

// Calculate subtotal
$subtotal = array_sum(array_column($data_gaji, 'total'));
$subtotal_rupiah = number_format($subtotal, 0, ',', '.');

// Store data in session for reuse
$_SESSION['data_gaji'] = $data_gaji;
$_SESSION['subtotal'] = $subtotal_rupiah;
$_SESSION['DETAIL'] = [
    'nm_karyawan' => $nm_karyawan,
    'tanggal_gajian' => $tanggal_gajian,
];

// PDF generation function
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => 10,
    'default_font' => 'Arial'
]);

function formatTanggalIndonesia($tanggal) {
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

    $date = strtotime($tanggal);
    $hari = $hariIndo[date('l', $date)];
    $tanggal = date('d', $date);
    $bulan = $bulanIndo[(int)date('m', $date)];
    $tahun = date('Y', $date);

    return "$hari, $tanggal $bulan $tahun";
}

$tanggalIndonesia = formatTanggalIndonesia($tanggal_gajian);

if (!empty($data_gaji)) {
    $common_details = $data_gaji[0];
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
                    <td style="width: 5%;">Tanggal</td>
                    <td style="width: 70%;">: ' . $tanggalIndonesia . '</td>
                </tr>
                <tr>
                    <td style="width: 5%;">No.      </td>
                    <td style="width: 70%;">: ' . htmlspecialchars($common_details['nota_number']) . '</td>
                </tr>
                <tr>
                    <td style="width: 5%;">Nama</td>
                    <td style="width: 70%;">: ' . htmlspecialchars($common_details['nm_karyawan']) . '</td>
                </tr>
                <tr>
                    <td style="width: 5%;">Bagian</td>
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
} else {
    echo "No data found!";
}
?>
