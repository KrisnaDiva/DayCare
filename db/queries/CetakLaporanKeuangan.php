<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();

$startDate = isset($_GET['tanggal_awal']) ? date('Y-m-d', strtotime($_GET['tanggal_awal'])) : date('Y-m-d');
$endDate = isset($_GET['tanggal_akhir']) ? date('Y-m-d', strtotime($_GET['tanggal_akhir'])) : date('Y-m-d');

$sql = "SELECT SUM(total_bayar) as total_pemasukan FROM transaksi WHERE status = 'dibayar' AND DATE(tanggal_transaksi) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$pendapatan_jasa = $stmt->fetchColumn();

$sql = "SELECT SUM(total_pengeluaran) as total_pengeluaran FROM pengeluaran WHERE status = 'diterima' AND DATE(tanggal) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$pengeluaran_harian = $stmt->fetchColumn();

$sql = "SELECT SUM(total) as total FROM hutang_piutang WHERE jenis = 'Hutang' AND status = 'Belum Lunas' AND DATE(tanggal_pinjam) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$total_hutang = $stmt->fetchColumn();

$sql = "SELECT SUM(total) as total FROM hutang_piutang WHERE jenis = 'Piutang' AND status = 'Lunas' AND DATE(tanggal_dibayar) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$total_piutang = $stmt->fetchColumn();

$total_hutang_piutang = $total_hutang + $total_piutang;

$sql = "SELECT periode, tanggal_bayar, SUM(total) as total FROM penggajian WHERE DATE(tanggal_bayar) BETWEEN :startDate AND :endDate GROUP BY tanggal_bayar";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$penggajian = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_penggajian = 0;
foreach ($penggajian as $gaji) {
    $total_penggajian += $gaji['total'];
}

$sql = "SELECT SUM(total) as total FROM hutang_piutang WHERE jenis = 'Hutang' AND status = 'Lunas' AND DATE(tanggal_dibayar) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$total_hutang2 = $stmt->fetchColumn();

$sql = "SELECT SUM(total) as total FROM hutang_piutang WHERE jenis = 'Piutang' AND status = 'Belum Lunas' AND DATE(tanggal_pinjam) BETWEEN :startDate AND :endDate";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$total_piutang2 = $stmt->fetchColumn();

$total_hutang_piutang2 = $total_hutang2 + $total_piutang2;

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
    .date-printed {
        text-align: right;
    }
</style>
<p class='date-printed'>Tanggal Dicetak: " . date('d-m-Y') . "</p>
<h2>Laporan Keuangan</h2>
<p>Periode : " . date('d-m-Y', strtotime($startDate)) . " - " . date('d-m-Y', strtotime($endDate)) . "</p>
<table>
    <thead>
        <tr>
            <th colspan='2'>Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Pendapatan Jasa:</td>
            <td>Rp" . number_format($pendapatan_jasa, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <td>Hutang Piutang:</td>
            <td>Rp" . number_format($total_hutang_piutang, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <th>Total Pendapatan:</th>
            <td>Rp" . number_format($pendapatan_jasa + $total_hutang_piutang, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <th colspan='2'>Pengeluaran</th>
        </tr>
        <tr>
            <td>Pengeluaran Harian:</td>
            <td>Rp" . number_format($pengeluaran_harian, 0, ',', '.') . "</td>
        </tr>";
foreach ($penggajian as $gaji) {
    $html .= "<tr>
                <td>Penggajian: " . date('F Y', strtotime($gaji['periode'])) . "</td>
                <td>Rp" . number_format($gaji['total'], 0, ',', '.') . "</td>
            </tr>";
}
$html .= "<tr>
            <td>Hutang Piutang:</td>
            <td>Rp" . number_format($total_hutang_piutang2, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <th>Total Pengeluaran:</th>
            <td>Rp" . number_format($total_penggajian + $pengeluaran_harian + $total_hutang_piutang2, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <th>Laba/Rugi:</th>
            <td>Rp" . number_format($pendapatan_jasa + $total_hutang_piutang - ($total_penggajian + $pengeluaran_harian + $total_hutang_piutang2), 0, ',', '.') . "</td>
        </tr>
    </tbody>
</table>";

$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$mpdf->WriteHTML($html);

$mpdf->Output('Laporan Keuangan.pdf', 'I');