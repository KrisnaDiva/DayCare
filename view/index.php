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

    $datesOfLast7Days = array();
    for ($i = 6; $i >= 0; $i--) {
        $datesOfLast7Days[] = date('Y-m-d', strtotime("-$i day"));
    }

    $statement = $koneksi->prepare("SELECT DATE(tanggal_transaksi) as day, COUNT(*) as count
        FROM transaksi
        WHERE status = 'dibayar' AND tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(tanggal_transaksi)");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dataPointsWeek = array();
    sort($datesOfLast7Days);

    foreach ($datesOfLast7Days as $date) {
        $count = 0;

        foreach ($rows as $row) {
            if ($row['day'] == $date) {
                $count = $row['count'];
                break;
            }
        }

        $dataPointsWeek[] = array("y" => $count, "label" => $date);
    }

    $startDatesOfLast4Weeks = array();
    for ($i = 3; $i >= 0; $i--) {
        $startDatesOfLast4Weeks[] = date('Y-m-d', strtotime("monday this week -{$i} week"));
    }

    $statement = $koneksi->prepare("SELECT DATE(tanggal_transaksi) as day, COUNT(*) as count
        FROM transaksi
        WHERE status = 'dibayar' AND WEEKOFYEAR(tanggal_transaksi) >= WEEKOFYEAR(DATE_SUB(CURDATE(), INTERVAL 4 WEEK))
        GROUP BY WEEKOFYEAR(tanggal_transaksi)");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dataPoints4Weeks = array();
    foreach ($startDatesOfLast4Weeks as $startDate) {
        $count = 0;

        $endDate = date('Y-m-d', strtotime("$startDate +6 day"));

        $label = "$startDate - $endDate";

        foreach ($rows as $row) {
            if (date('W', strtotime($row['day'])) == date('W', strtotime($startDate))) {
                $count = $row['count'];
                break;
            }
        }

        $dataPoints4Weeks[] = array("y" => $count, "label" => $label);
    }

    $monthsOfLast12Months = array();
    for ($i = 11; $i >= 0; $i--) {
        $monthsOfLast12Months[] = date('Y-m', strtotime("-$i month"));
    }

    $statement = $koneksi->prepare("SELECT DATE_FORMAT(tanggal_transaksi, '%Y-%m') as month, COUNT(*) as count
        FROM transaksi
        WHERE status = 'dibayar' AND tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(tanggal_transaksi, '%Y-%m')");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dataPointsYear = array();
    foreach ($monthsOfLast12Months as $month) {
        $count = 0;

        foreach ($rows as $row) {
            if ($row['month'] == $month) {
                $count = $row['count'];
                break;
            }
        }

        $dataPointsYear[] = array("y" => $count, "label" => date('F', strtotime($month)));
    }
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
                                <p class="card-category">Order</p>
                                <h4 class="card-title"><?= $total_order ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <select id="timeframe" class="form-control col-5">
            <option value="week">7 Hari Terakhir</option>
            <option value="4weeks">4 Minggu Terakhir</option>
            <option value="year">12 Bulan Terakhir</option>
        </select>

        <div id="chartContainer" class="col-8" style="height: 370px; width: 100%;"></div>
    </div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        function renderChart(dataPoints, title) {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: title
                },
                axisY: {
                    title: "Angka Penjualan"
                },
                data: [{
                    type: "line",
                    dataPoints: dataPoints
                }]
            });
            chart.render();
        }

        document.getElementById('timeframe').addEventListener('change', function () {
            var timeframe = this.value;
            var dataPoints;
            var title;

            switch (timeframe) {
                case 'week':
                    dataPoints = <?php echo json_encode($dataPointsWeek, JSON_NUMERIC_CHECK); ?>;
                    title = "Penjualan Dalam 7 Hari Terakhir";
                    break;
                case '4weeks':
                    dataPoints = <?php echo json_encode($dataPoints4Weeks, JSON_NUMERIC_CHECK); ?>;
                    title = "Penjualan Dalam 4 Minggu Terakhir";
                    break;
                case 'year':
                    dataPoints = <?php echo json_encode($dataPointsYear, JSON_NUMERIC_CHECK); ?>;
                    title = "Penjualan Dalam 12 Bulan Terakhir";
                    break;
            }

            renderChart(dataPoints, title);
        });

        window.onload = function () {
            var dataPoints = <?php echo json_encode($dataPointsWeek, JSON_NUMERIC_CHECK); ?>;
            var title = "Penjualan Dalam Seminggu";
            renderChart(dataPoints, title);
        }
    </script><?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>