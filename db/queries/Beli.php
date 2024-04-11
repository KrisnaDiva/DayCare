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
$total_bayar = $_POST['harga'];  // assuming this is the total amount to be paid

// Prepare the transaction data for Midtrans
$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $total_bayar,
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
    'anak_id' => $anak_id,
    'jenis_paket_id' => $jenis_paket_id,
    'total_bayar' => $total_bayar,
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