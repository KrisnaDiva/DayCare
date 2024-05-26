<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();
$id = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "SELECT * FROM penggajian WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$penggajian = $stmt->fetch();

$sql = "SELECT * FROM detail_penggajian WHERE penggajian_id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$detail_penggajian = $stmt->fetchAll();

$html = "
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    .right {
        text-align: right;
    }
</style>
<div class='right'><p>Tanggal Percetakan: " . date("d-m-Y") . "</p></div>
<p><strong>Periode:</strong> {$penggajian['periode']}</p>
<p><strong>Tanggal Bayar:</strong> {$penggajian['tanggal_bayar']}</p>
<p><strong>Total:</strong> Rp" . number_format($penggajian['total'], 0, ',', '.') . "</p>
";

$html .= "<h2>Detail Penggajian</h2>";

$html .= "<table border='1'>
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
        </tr>
    </thead>
    <tbody>";

foreach ($detail_penggajian as $detail) {
    $html .= "<tr>
        <td>{$detail['nama_karyawan']}</td>
        <td>Rp" . number_format($detail['gaji_pokok'], 0, ',', '.') . "</td>
        <td>Rp" . number_format($detail['tunjangan'], 0, ',', '.') . "</td>
    </tr>";
}

$html .= "</tbody></table>";

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Detail Penggajian.pdf', 'I');