<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();
$status = isset($_GET['status']) ? $_GET['status'] : null;
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;

if ($status) {
    $sql = "SELECT * FROM pengeluaran WHERE status = :status";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " AND tanggal BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
} else {
    $sql = "SELECT * FROM pengeluaran";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " WHERE tanggal BETWEEN :tanggal_awal AND :tanggal_akhir";
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
$pengeluaran = $statement->fetchAll();
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
<h1>Laporan Pengeluaran</h1>

";
$html .= "<table border='1'>
    <thead>
        <tr>
              <th>Total Pengeluaran</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Dibuat Oleh</th>
        </tr>
    </thead>
    <tbody>";

foreach ($pengeluaran as $peng) {
    $sql = "SELECT nama FROM users WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$peng['user_id']]);
    $admin = $statement->fetch();
    $html .= "<tr>
        <td>{$peng['total_pengeluaran']}</td>
        <td>{$peng['keterangan']}</td>
        <td>{$peng['tanggal']}</td>
        <td>{$peng['status']}</td>
        <td>{$admin['nama']}</td>
    </tr>";
}

$html .= "</tbody></table>";
$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Transaksi.pdf', 'I');