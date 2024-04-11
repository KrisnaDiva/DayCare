<?php
require_once __DIR__ . '/../../db/koneksi.php';
$koneksi = getKoneksi();

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE transaksi SET status = ? WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$status, $id]);

$koneksi = null;
if ($status == 'dibatalkan') {
    echo "<script type='text/javascript'>
                alert('Pesanan Dibatalkan');
                window.location.href = '../../view/pesanan.php';
              </script>";
}