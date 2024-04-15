<?php
$title = "Checkout";
ob_start();
session_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$status = isset($_GET['status']) ? $_GET['status'] : 'dibayar';

$limit = 5; // Jumlah pesanan per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM transaksi WHERE user_id = ? AND status = ? LIMIT $limit OFFSET $offset";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id'], $status]);
$pending = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM transaksi WHERE user_id = ? AND status = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id'], $status]);
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>

    <ul class="nav nav-tabs justify-content-center mb-5">
        <li class="nav-item">
            <a class="nav-link <?= $status == 'dibayar' ? 'active' : '' ?>"
               href="pesanan.php?status=dibayar">Dibayar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $status == 'belum dibayar' ? 'active' : '' ?>"
               href="pesanan.php?status=belum%20dibayar">Belum Dibayar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $status == 'dibatalkan' ? 'active' : '' ?>" href="pesanan.php?status=dibatalkan">Dibatalkan</a>
        </li>
    </ul>
    <div class="row justify-content-center">

<?php foreach ($pending as $value): ?>
    <div class="col-10">
        <div class="card ">

            <div class="card-body">
                <div class="row justify-content-between px-5 mb-3">
                    <small class="text-muted"> <?= date("d-m-Y H:i", strtotime($value['tanggal_transaksi'])) ?></small>
                    <?php if ($value['status'] == 'belum dibayar'): ?>
                        <small class="text-muted">Bayar
                            Sebelum <?= date("d-m-Y H:i", strtotime($value['tanggal_transaksi'] . '+1 day')) ?></small>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="row text-center mb-3 font-weight-bold">
                    <div class="col-2">
                        Nama Paket
                    </div>
                    <div class="col-2">
                        Periode
                    </div>
                    <div class="col-2">
                        Jenis
                    </div>
                    <div class="col-2">
                        Anak
                    </div>
                    <div class="col-2">
                        Harga
                    </div>
                    <div class="col-2">
                        Status
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-2">
                        <?= htmlspecialchars($value['nama_paket']); ?> (<?= htmlspecialchars($value['usia_paket']); ?>)
                    </div>
                    <div class="col-2">
                        <?= $value['periode_paket']; ?>
                    </div>
                    <div class="col-2">
                        <?= $value['jenis_paket']; ?>
                    </div>
                    <div class="col-2">
                        <?= $value['nama_anak']; ?>
                    </div>
                    <div class="col-2">
                        <?= 'Rp' . number_format($value['total_bayar'], 0, ',', '.'); ?>                    </div>
                    <div class="col-2">
                        <?= $value['status']; ?>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-end px-5">
                    <?php if ($value['status'] == 'belum dibayar'): ?>
                        <a href="javascript:if(confirm('Apakah anda yakin mau membatalkan pesanan?')) window.location.href='../db/queries/BayarDanBatal.php?id=<?= $value['id'] ?>&status=dibatalkan';"
                           class="btn btn-danger">Batal</a>
                        <button type="submit" id="pay-button-<?= $value['id'] ?>" class="btn btn-success ml-3">Bayar
                        </button>
                    <?php elseif ($value['status'] == 'dibayar'): ?>
                        <a href="../db/queries/CetakTransaksi.php?id=<?= $value['id'] ?>" class="btn btn-primary ml-3">Cetak
                            Detail
                            Transaksi</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?php echo 'SB-Mid-client-DydJ4fTsGZX-Vzzk' ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button-<?= $value['id'] ?>').onclick = function () {
            snap.pay('<?php echo $value['snap_token']?>', {
                onSuccess: function (result) {
                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.open("GET", "../db/queries/BayarDanBatal.php?id=<?= $value['id'] ?>&status=dibayar");
                    xmlhttp.send();
                    alert('Transaksi Berhasil');
                    window.location.href = 'pesanan.php';
                }
            });
        };
    </script>
<?php endforeach; ?>

  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <!-- First page link -->
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="pesanan.php?status=<?= $status ?>&page=1">First</a>
        </li>
        <!-- Previous page link -->
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="pesanan.php?status=<?= $status ?>&page=<?= $page - 1 ?>"><</a>
        </li>
        <?php
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="pesanan.php?status=<?= $status ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <!-- Next page link -->
        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="pesanan.php?status=<?= $status ?>&page=<?= $page + 1 ?>">></a>
        </li>
        <!-- Last page link -->
        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="pesanan.php?status=<?= $status ?>&page=<?= $total_pages ?>">Last</a>
        </li>
    </ul>
</nav>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>