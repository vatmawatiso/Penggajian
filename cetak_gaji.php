<?php
require_once __DIR__ . './mpdf_v8.0.3-master/vendor/autoload.php';
session_start();

use Mpdf\Mpdf;

// Sample data from session (replace this with your session data)
$data_gaji = $_SESSION['data_gaji'] ?? [];
$subtotal_rupiah = $_SESSION['subtotal'] ?? 'Rp 0';

// Initialize mPDF for thermal paper size (80mm wide)
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => [80, 220], // 80mm wide, height auto-adjusts
    'default_font_size' => 10,
    'default_font' => 'Arial'
]);

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
            .header { text-align: center; }
            .header h1 { margin: 0; font-size: 14pt; }
            .header p { margin: 0; }
            .table { width: 100%; border-collapse: collapse; margin-bottom: 10mm; }
            .table td { border: none; padding: 5px; text-align: left; }
            .table .right { text-align: right; }
            .footer { text-align: right; margin-top: 10mm; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>ADITYA ROTAN</h1>
            <p>Desa Pamijahan Kec. Plumbon Kabupaten Cirebon</p>
            <h2>SLIP GAJI</h2>
        </div>
        <table class="table">
            <tr>
                <td>Nama</td>
                <td>: ' . htmlspecialchars($common_details['nama_karyawan']) . '</td>
            </tr>
        </table>';

    $html .= '<table class="table">';
    foreach ($data_gaji as $gaji) {
        $html .= '
        <tr>
            <td>Bagian</td>
            <td class="right">' . htmlspecialchars($gaji['nama_bagian']) . '</td>
        </tr>
        <tr>
            <td>Produk</td>
            <td class="right">' . htmlspecialchars($gaji['nama_produk']) . '</td>
        </tr>
        <tr>
            <td>Harga</td>
            <td class="right">' . htmlspecialchars($gaji['harga']) . '</td>
        </tr>
        <tr>
            <td>Total Kerja</td>
            <td class="right">' . htmlspecialchars($gaji['bil2']) . ' Mengerjakan</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="right">' . htmlspecialchars($gaji['hasil']) . '</td>
        </tr>
        <tr><td colspan="2"><hr></td></tr>';
    }
    $html .= '
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td class="right"><strong>' . htmlspecialchars($subtotal_rupiah) . '</strong></td>
        </tr>
    </table>';

    $html .= '
        <div class="footer">
            <p>Cirebon, ' . date('j F Y') . '</p>
            <p>Lili Rahayu<br>(Admin)</p>
        </div>
    </body>
    </html>';

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Output the PDF to the browser
    $mpdf->Output('Slip_Gaji_Karyawan_' . htmlspecialchars($common_details['nama_karyawan']) . '.pdf', \Mpdf\Output\Destination::INLINE);
}
?>
