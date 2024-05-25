<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();
$status = isset($_GET['status']) ? $_GET['status'] : 'dibayar';
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;

if ($status) {
    $sql = "SELECT * FROM transaksi WHERE status = :status";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " AND tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
} else {
    $sql = "SELECT * FROM transaksi";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " WHERE tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
}

$statement = $koneksi->prepare($sql);
if ($status) {
    $statement->bindParam(':status', $status);
}
if ($tanggal_awal && $tanggal_akhir) {
    $statement->bindParam(':tanggal_awal', $tanggal_awal);
    $statement->bindParam(':tanggal_akhir', $tanggal_akhir);
}
$statement->execute();
$transaksi = $statement->fetchAll(PDO::FETCH_ASSOC);

$totalBayar = 0; // Variabel untuk total transaksi

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
<h1>Laporan Transaksi</h1>
<p>Tanggal Percetakan: " . date("d-m-Y") . "</p>
";

$html .= "<table border='1'>
    <thead>
        <tr>
            <th>ID Transaksi</th>
            <th>Nama Paket</th>
            <th>Periode Paket</th>
            <th>Jenis Paket</th>
            <th>Pembeli</th>
            <th>Nama Anak</th>
            <th>Status</th>
            <th>Total Bayar</th>
            <th>Tanggal Transaksi</th>
        </tr>
    </thead>
    <tbody>";

foreach ($transaksi as $trans) {
    $sql = "SELECT nama FROM users WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$trans['user_id']]);
    $pembeli = $statement->fetch();
    $html .= "<tr>
        <td>{$trans['id']}</td>
        <td>{$trans['nama_paket']} ({$trans['usia_paket']})</td>
        <td>{$trans['periode_paket']}</td>
        <td>{$trans['jenis_paket']}</td>
        <td>{$pembeli['nama']}</td>
        <td>{$trans['nama_anak']}</td>
        <td>{$trans['status']}</td>
        <td>Rp" . number_format($trans['total_bayar'], 0, ',', '.') . "</td>
        <td>" . date("d-m-Y", strtotime($trans['tanggal_transaksi'])) . "</td>
    </tr>";

    $totalBayar += $trans['total_bayar']; // Menambahkan total transaksi
}

$html .= "</tbody></table>";

// Menampilkan total transaksi
$html .= "<h3>Total Transaksi: Rp" . number_format($totalBayar, 0, ',', '.') . "</h3>";

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Transaksi.pdf', 'I');