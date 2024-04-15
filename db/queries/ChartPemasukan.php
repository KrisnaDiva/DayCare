<?php
require_once __DIR__ . '/../koneksi.php';
$koneksi = getKoneksi();

$lastSevenDaysDates = array();
for ($i = 6; $i >= 0; $i--) {
    $lastSevenDaysDates[] = date('Y-m-d', strtotime("-$i day"));
}

$statement = $koneksi->prepare("SELECT DATE(tanggal_transaksi) as transactionDay, SUM(total_bayar) as totalPayment
    FROM transaksi
    WHERE status = 'dibayar' AND tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY DATE(tanggal_transaksi)");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$weeklyDataPoints = array();
sort($lastSevenDaysDates);

foreach ($lastSevenDaysDates as $date) {
    $totalPayment = 0;

    foreach ($rows as $row) {
        if ($row['transactionDay'] == $date) {
            $totalPayment = $row['totalPayment'];
            break;
        }
    }

    $weeklyDataPoints[] = array("y" => $totalPayment, "label" => $date);
}

$lastFourWeeksStartDates = array();
for ($i = 3; $i >= 0; $i--) {
    $lastFourWeeksStartDates[] = date('Y-m-d', strtotime("monday this week -{$i} week"));
}

$statement = $koneksi->prepare("SELECT DATE(tanggal_transaksi) as transactionDay, SUM(total_bayar) as totalPayment
    FROM transaksi
    WHERE status = 'dibayar' AND WEEKOFYEAR(tanggal_transaksi) >= WEEKOFYEAR(DATE_SUB(CURDATE(), INTERVAL 4 WEEK))
    GROUP BY WEEKOFYEAR(tanggal_transaksi)");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$monthlyDataPoints = array();
foreach ($lastFourWeeksStartDates as $startDate) {
    $totalPayment = 0;

    $endDate = date('Y-m-d', strtotime("$startDate +6 day"));

    $label = "$startDate - $endDate";

    foreach ($rows as $row) {
        if (date('W', strtotime($row['transactionDay'])) == date('W', strtotime($startDate))) {
            $totalPayment = $row['totalPayment'];
            break;
        }
    }

    $monthlyDataPoints[] = array("y" => $totalPayment, "label" => $label);
}

$lastTwelveMonths = array();
for ($i = 11; $i >= 0; $i--) {
    $lastTwelveMonths[] = date('Y-m', strtotime("-$i month"));
}

$statement = $koneksi->prepare("SELECT DATE_FORMAT(tanggal_transaksi, '%Y-%m') as transactionMonth, SUM(total_bayar) as totalPayment
    FROM transaksi
    WHERE status = 'dibayar' AND tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY DATE_FORMAT(tanggal_transaksi, '%Y-%m')");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$yearlyDataPoints = array();
foreach ($lastTwelveMonths as $month) {
    $totalPayment = 0;

    foreach ($rows as $row) {
        if ($row['transactionMonth'] == $month) {
            $totalPayment = $row['totalPayment'];
            break;
        }
    }

    $yearlyDataPoints[] = array("y" => $totalPayment, "label" => date('F Y', strtotime($month)));
}
?>

<div class="row justify-content-center">
    <select id="timeframeSelector" class="form-control col-11">
        <option value="week" selected>7 Hari Terakhir</option>
        <option value="4weeks">4 Minggu Terakhir</option>
        <option value="year">12 Bulan Terakhir</option>
    </select>
    <div id="paymentChartContainer" class="col-11" style="height: 370px; width: 100%;"></div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    function renderPaymentChart(dataPoints, title) {
        var chart = new CanvasJS.Chart("paymentChartContainer", {
            title: {
                text: title
            },
            axisY: {
                title: "Total Pemasukan"
            },
            data: [{
                type: "line",
                dataPoints: dataPoints
            }]
        });
        chart.render();
    }

    document.getElementById('timeframeSelector').addEventListener('change', function () {
        var timeframe = this.value;
        var dataPoints;
        var title;

        switch (timeframe) {
            case 'week':
                dataPoints = <?php echo json_encode($weeklyDataPoints, JSON_NUMERIC_CHECK); ?>;
                title = "Pemasukan Dalam 7 Hari Terakhir";
                break;
            case '4weeks':
                dataPoints = <?php echo json_encode($monthlyDataPoints, JSON_NUMERIC_CHECK); ?>;
                title = "Pemasukan Dalam 4 Minggu Terakhir";
                break;
            case 'year':
                dataPoints = <?php echo json_encode($yearlyDataPoints, JSON_NUMERIC_CHECK); ?>;
                title = "Pemasukan Dalam 12 Bulan Terakhir";
                break;
        }

        renderPaymentChart(dataPoints, title);
    });

    window.onload = function () {
        var dataPoints = <?php echo json_encode($weeklyDataPoints, JSON_NUMERIC_CHECK); ?>;
        var title = "Pemasukan Dalam Seminggu";
        renderPaymentChart(dataPoints, title);
    }
</script>