<?php
$title = "Dashboard";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
session_start();
$statement = $koneksi->prepare("SELECT * FROM users WHERE id = ?");
$statement->execute([$_SESSION['id']]);
$user = $statement->fetch();

if ($user['role'] == 'user') {

} else {
    $statement = $koneksi->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
    $statement->execute();
    $count_user = $statement->fetchColumn();

    $statement = $koneksi->prepare("SELECT SUM(total_bayar) as total FROM transaksi WHERE status = 'dibayar'");
    $statement->execute();
    $total_pemasukan = $statement->fetchColumn();

    $statement = $koneksi->prepare("SELECT COUNT(*) as count FROM transaksi WHERE status = 'dibayar'");
    $statement->execute();
    $total_order = $statement->fetchColumn();

    $statement = $koneksi->prepare("SELECT COUNT(*) as count FROM anak");
    $statement->execute();
    $total_anak = $statement->fetchColumn();



}
?>
<?php if ($user['role'] == 'user'): ?>
    <p>Ini adalah paragraf di halaman index.</p>
<?php else: ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-stats card-warning">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-users"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">User</p>
                                <h4 class="card-title"><?= $count_user ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats card-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="las la-child"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Anak</p>
                                <h4 class="card-title"><?= $total_anak ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php if ($user['role'] == 'owner'): ?>
        <div class="col-md-3">
            <div class="card card-stats card-success">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-bar-chart"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Pemasukan</p>
                                <h4 class="card-title">Rp<?= number_format($total_pemasukan, 0, ',', '.') ?></h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <div class="col-md-3">
            <div class="card card-stats card-primary">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-check-circle"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Penjualan</p>
                                <h4 class="card-title"><?= $total_order ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php if ($user['role'] == 'owner'): ?>
<ul class="nav nav-tabs justify-content-center mb-5">
    <li class="nav-item">
        <a class="nav-link <?php echo ($_GET['chart'] ?? 'penjualan') == 'penjualan' ? 'active' : '' ?>" href="index.php?chart=penjualan">Chart Penjualan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($_GET['chart'] ?? 'penjualan') == 'pemasukan' ? 'active' : '' ?>" href="index.php?chart=pemasukan">Chart Pemasukan</a>
    </li>
</ul>
    <?php endif; ?>

    <?php
    $chart = $_GET['chart'] ?? 'penjualan';

    if ($chart == 'penjualan') {
        // Tampilkan chart penjualan
        require_once __DIR__.'/../db/queries/ChartPenjualan.php';
    } else if ($chart == 'pemasukan') {
        // Tampilkan chart pemasukan
        require_once __DIR__.'/../db/queries/ChartPemasukan.php';
    }
    ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>