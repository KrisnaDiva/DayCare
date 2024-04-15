<?php
require_once __DIR__ . '/../koneksi.php';
$koneksi = getKoneksi();

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

    $dataPointsYear[] = array("y" => $count, "label" => date('F Y', strtotime($month)));
}
?>

<div class="row justify-content-center">
    <select id="timeframe" class="form-control col-11">
        <option value="week" selected>7 Hari Terakhir</option>
        <option value="4weeks">4 Minggu Terakhir</option>
        <option value="year">12 Bulan Terakhir</option>
    </select>
    <div id="chartContainer" class="col-11" style="height: 370px; width: 100%;"></div>
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
</script>