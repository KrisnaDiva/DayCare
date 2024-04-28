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

    $statement = $koneksi->prepare("SELECT SUM(total_pengeluaran) as total FROM pengeluaran WHERE status = 'diterima'");
    $statement->execute();
    $total_pengeluaran = $statement->fetchColumn();


}
?>
<?php if ($user['role'] == 'user'): ?>
    <!DOCTYPE html>
    <html>
    <title>W3.CSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .mySlides {
            width: 700px;
            height: 600px;
            object-fit: contain;
        }
    </style>
    <h1 class="w3-center">Selamat Datang <?= $user['nama'] ?></h1>
    <div class="w3-content w3-display-container" style="max-width: 700px">
        <img class="mySlides" src="../assets/img/1.jpeg">
        <img class="mySlides" src="../assets/img/2.jpeg">
        <img class="mySlides" src="../assets/img/3.jpeg">
        <img class="mySlides" src="../assets/img/4.jpeg">
        <img class="mySlides" src="../assets/img/5.jpeg">
        <img class="mySlides" src="../assets/img/6.jpeg">

        <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
        <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
    </div>

    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex - 1].style.display = "block";
        }
    </script>

    </body>
    </html>
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
                                    <h4 class="card-title">Rp<?= number_format($total_pemasukan, 0, ',', '.') ?></h4>
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
                                    <i class="las la-money-bill-wave-alt"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Pengeluaran</p>
                                    <h4 class="card-title">Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></h4>
                                </div>
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
                <a class="nav-link <?= (isset($_GET['chart']) ? $_GET['chart'] : 'penjualan') == 'penjualan' ? 'active' : '' ?>"
                   href="index.php?chart=penjualan">Chart Penjualan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($_GET['chart']) ? $_GET['chart'] : 'penjualan') == 'pemasukan' ? 'active' : '' ?>"
                   href="index.php?chart=pemasukan">Chart Pemasukan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($_GET['chart']) ? $_GET['chart'] : 'penjualan') == 'pengeluaran' ? 'active' : '' ?>"
                   href="index.php?chart=pengeluaran">Chart Pengeluaran</a>
            </li>
        </ul>
    <?php endif; ?>

    <?php
    $chart = $_GET['chart'] ?? 'penjualan';

    if ($chart == 'penjualan') {
        require_once __DIR__ . '/../db/queries/ChartPenjualan.php';
    } else if ($chart == 'pemasukan') {
        require_once __DIR__ . '/../db/queries/ChartPemasukan.php';
    } else if ($chart == 'pengeluaran') {
        require_once __DIR__ . '/../db/queries/ChartPengeluaran.php';
    }
    ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>