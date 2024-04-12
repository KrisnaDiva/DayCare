<?php
require_once dirname(__FILE__) . '/../../vendor/midtrans/midtrans-php/Midtrans.php';
require_once __DIR__ . "/../koneksi.php";
session_start();
$koneksi = getKoneksi();

\Midtrans\Config::$serverKey = 'SB-Mid-server-UccWNdVCy74kbFk0uSRnYPs4'; // set your server key
\Midtrans\Config::$isProduction = false; // set to true for production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Get the necessary data from the form
$user_id = $_SESSION['id'];
$anak_id = $_POST['anak'];
$jenis_paket_id = $_POST['id'];
//$total_bayar = $_POST['harga'];

$sql = "SELECT nama From anak where id = ? ";
$statement = $koneksi->prepare($sql);
$statement->execute([$anak_id]);
$anak = $statement->fetch();

$sql = "SELECT * From jenis_paket where id = ? ";
$statement = $koneksi->prepare($sql);
$statement->execute([$jenis_paket_id]);
$jenis_paket = $statement->fetch();

$sql = "SELECT * FROM paket where id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$jenis_paket['paket_id']]);
$paket = $statement->fetch();

// Prepare the transaction data for Midtrans
$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $jenis_paket['harga'],
    ),
    // Add more data as needed
);

$snap_token = '';
try {
    $snap_token = \Midtrans\Snap::getSnapToken($params);
} catch (\Exception $e) {
    echo $e->getMessage();
}

$data = [
    'user_id' => $user_id,
    'nama_paket' => $paket['nama'],
    'usia_paket' => $paket['usia_minimal'] . ' - ' . $paket['usia_maksimal'] . ' tahun',
    'periode_paket' => $jenis_paket['periode'],
    'jenis_paket' => $jenis_paket['jenis'],
    'nama_anak' => $anak['nama'],
    'total_bayar' => $jenis_paket['harga'],
    'status' => 'belum dibayar',
    'snap_token' => $snap_token
];

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO transaksi ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Lakukan Pembayaran.');
            window.location.href = '../../view/pesanan.php?status=belum%20dibayar';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/checkout.php?id=$jenis_paket_id';
      </script>";
}

$koneksi = null;