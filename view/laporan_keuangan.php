<?php
$title = "Transaksi";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
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
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Laporan Keuangan</div>
                </div>
                <div class="card-body">
                    <form method="get" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="tanggal_awal" class="mr-2">Tanggal Awal:</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control mr-2"
                                   value="<?= $startDate ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="tanggal_akhir" class="mr-2">Tanggal Akhir:</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control mr-2"
                                   value="<?= $endDate ?>">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
                        <button type="button" class="btn btn-secondary ml-2" onclick="window.open('../db/queries/CetakLaporanKeuangan.php?tanggal_awal=' + document.getElementById('tanggal_awal').value + '&tanggal_akhir=' + document.getElementById('tanggal_akhir').value)">Cetak Laporan</button>
                    </form>
                    <table class="table text-left">
                        <tbody>
                        <tr>
                            <th colspan="2">Pendapatan</th>
                        </tr>
                        <tr>
                            <td>Pendapatan Jasa:</td>
                            <td>Rp<?= number_format($pendapatan_jasa, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>Hutang Piutang:</td>
                            <td>Rp<?= number_format($total_hutang_piutang, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Total Pendapatan:</th>
                            <td>Rp<?= number_format($pendapatan_jasa + $total_hutang_piutang, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th colspan="2">Pengeluaran</th>
                        </tr>
                        <tr>
                            <td>Pengeluaran Harian:</td>
                            <td>Rp<?= number_format($pengeluaran_harian, 0, ',', '.') ?></td>
                        </tr>
                        <?php foreach ($penggajian as $gaji): ?>
                            <tr>
                                <td>Penggajian: <?= date('F Y', strtotime($gaji['periode'])) ?></td>
                                <td>Rp<?= number_format($gaji['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Hutang Piutang:</td>
                            <td>Rp<?= number_format($total_hutang_piutang2, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Total Pengeluaran:</th>
                            <td>
                                Rp<?= number_format($total_penggajian + $pengeluaran_harian + $total_hutang_piutang2, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Laba/Rugi:</th>
                            <td>
                                Rp<?= number_format($pendapatan_jasa + $total_hutang_piutang - ($total_penggajian + $pengeluaran_harian + $total_hutang_piutang2), 0, ',', '.') ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>