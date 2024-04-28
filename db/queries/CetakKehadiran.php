<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$sql = "SELECT * FROM kehadiran WHERE tanggal = :tanggal";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':tanggal', $tanggal);
$statement->execute();
$kehadiran = $statement->fetchAll(PDO::FETCH_ASSOC);

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
</style>
<h1>Laporan Kehadiran</h1>
";

$html .= "<table border='1'>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anak</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
        </tr>
    </thead>
    <tbody>";

foreach ($kehadiran as $key => $value) {
    $sql = "SELECT nama FROM anak WHERE id = :id";
    $statement = $koneksi->prepare($sql);
    $statement->bindParam(':id', $value['anak_id']);
    $statement->execute();
    $anak = $statement->fetch();

    $html .= "<tr>
        <td>" . ($key + 1) . "</td>
        <td>{$anak['nama']}</td>
        <td>{$value['tanggal']}</td>
        <td>{$value['jam_masuk']}</td>
        <td>{$value['jam_keluar']}</td>
    </tr>";
}

$html .= "</tbody></table>";
$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Kehadiran.pdf', 'I');