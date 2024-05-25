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

    .tanggal-pencetakan {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
<h1>Laporan Pengeluaran Harian</h1>

<div class='tanggal-pencetakan'>Tanggal Pencetakan: " . date("d-m-Y") . "</div>


";
$html .= "<table border='1'>
    <thead>
        <tr>
              <th>No</th>
              <th>Total Pengeluaran</th>
              <th>Detail Pengeluaran</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Dibuat Oleh</th>
        </tr>
    </thead>
    <tbody>";

$totalHarga = 0; // Variabel untuk total harga
$no = 1; // Variabel untuk nomor
foreach ($pengeluaran as $peng) {
    // Query untuk mendapatkan detail_pengeluaran
    $sql = "SELECT * FROM detail_pengeluaran WHERE pengeluaran_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$peng['id']]);
    $detail_pengeluaran = $stmt->fetchAll();

    // Menggabungkan semua detail_pengeluaran menjadi string
    $detail_pengeluaran_str = "";
    foreach ($detail_pengeluaran as $detail) {
        $detail_pengeluaran_str .= $detail['jenis_pengeluaran'] . ": " . "Rp" . number_format($detail['pengeluaran'], 0, ',', '.') . ", ";
    }
    $detail_pengeluaran_str = rtrim($detail_pengeluaran_str, ", "); // Menghapus koma dan spasi di akhir string

    $sql = "SELECT nama FROM users WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$peng['user_id']]);
    $admin = $statement->fetch();
    $formatted_pengeluaran = "Rp" . number_format($peng['total_pengeluaran'], 0, ',', '.');
    $html .= "<tr>
        <td>{$no}</td>
        <td>{$formatted_pengeluaran}</td>
        <td>{$detail_pengeluaran_str}</td>
        <td>{$peng['keterangan']}</td>
        <td>{$peng['tanggal']}</td>
        <td>{$peng['status']}</td>
        <td>{$admin['nama']}</td>
    </tr>";
    $no++; // Menambahkan 1 ke nomor
    $totalHarga += $peng['total_pengeluaran']; // Menambahkan pengeluaran ke total harga
}

$html .= "</tbody></table>";

// Menampilkan total harga di luar tabel
$html .= "<h3>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</h3>";


$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Transaksi.pdf', 'I');