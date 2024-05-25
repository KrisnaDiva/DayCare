<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';
$koneksi = getKoneksi();

$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;

$sql = "SELECT * FROM hutang_piutang WHERE 1=1"; // default query

if ($jenis) {
    $sql .= " AND jenis = :jenis";
}
if ($status) {
    $sql .= " AND status = :status";
}
if ($tanggal_awal && $tanggal_akhir) {
    $sql .= " AND tanggal_pinjam BETWEEN :tanggal_awal AND :tanggal_akhir";
}

$statement = $koneksi->prepare($sql);
if ($jenis) {
    $statement->bindParam(':jenis', $jenis);
}
if ($status) {
    $statement->bindParam(':status', $status);
}
if ($tanggal_awal && $tanggal_akhir) {
    $statement->bindParam(':tanggal_awal', $tanggal_awal);
    $statement->bindParam(':tanggal_akhir', $tanggal_akhir);
}
$statement->execute();
$hutang_piutang = $statement->fetchAll();

// The rest of your code remains the same
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

    .tanggal-pencetakan {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
<h1>Laporan Hutang Piutang</h1>

<div class='tanggal-pencetakan'>Tanggal Pencetakan: " . date("d-m-Y") . "</div>


";
$html .= "<table border='1'>
    <thead>
        <tr>
            <th>No</th>
            <th>Total</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Keterang</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Dibayar</th>
        </tr>
    </thead>
    <tbody>";

foreach ($hutang_piutang as $key => $value) {
    $html .= "<tr>
        <td>" . ($key + 1) . "</td>
        <td>Rp" . number_format($value['total'], 0, ',', '.') . "</td>
        <td>" . htmlspecialchars($value['jenis']) . "</td>
        <td>" . htmlspecialchars($value['status']) . "</td>
        <td>" . htmlspecialchars($value['keterangan']) . "</td>
        <td>" . htmlspecialchars($value['tanggal_pinjam']) . "</td>
        <td>" . htmlspecialchars($value['tanggal_dibayar']) . "</td>
    </tr>";
}

$html .= "</tbody></table>";

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Hutang Piutang.pdf', 'I');