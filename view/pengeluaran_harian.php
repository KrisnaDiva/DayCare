<?php
$title = "Laporan Harian";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$mulai = isset($_GET['mulai']) ? $_GET['mulai'] : null;
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : null;
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : null;
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : null;
$akhirr = date('d', strtotime($akhir));
$tanggal_mulai = "$tahun-$bulan-$mulai";
$tanggal_akhir = "$tahun-$bulan-$akhirr";

$sql = "SELECT * FROM pengeluaran WHERE tanggal BETWEEN ? AND ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$tanggal_mulai, $tanggal_akhir]);
$pengeluaran = $statement->fetchAll();
?>

<div class="row justify-content-center mb-3">
   <?php
for ($i = $mulai; $i <= $akhirr; $i++) {
    $currentDate = date('Y-m-d');
    $displayedDate = date('Y-m-d', mktime(0, 0, 0, $bulan, $i, $tahun));
    $isFuture = $currentDate < $displayedDate;
    $status = 'belum-diisi';
    $isAccepted = false;

    foreach ($pengeluaran as $item) {
        if ($item['tanggal'] == $displayedDate) {
            if ($item['status'] == 'diterima') {
                $isAccepted = true;
                $status = 'diterima';
            } elseif ($item['status'] == 'ditolak') {
                $status = 'ditolak';
            }
            break;
        }
    }
    ?>
    <div class="card col-8 p-5">
        <div class="row">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <div class="profile-pic ">
                    <img src="../assets/img/<?= $status ?>.png" alt="user-img" width="50" class="img-circle border">
                </div>
                <div class="ml-3"><?= "{$i} " . date('F', mktime(0, 0, 0, $bulan)) . " {$tahun}"; ?></div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-primary " <?= $isFuture || $isAccepted ? 'disabled' : '' ?>>Buat Laporan Harian</button>
            </div>
        </div>
    </div>
    <?php
}
?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>