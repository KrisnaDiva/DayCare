<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_GET['id'];

$statement = $koneksi->prepare("UPDATE hutang_piutang SET status = 'Lunas', tanggal_dibayar = NOW() WHERE id = ?");
$statement->execute([$id]);

if ($statement->rowCount() > 0) {
    echo "<script type='text/javascript'>
                alert('Berhasil Dibayar.');
                window.location.href = '../../view/hutang_piutang.php';
              </script>";
} else {
    echo "<script type='text/javascript'>
        alert('Gagal Dibayar');
        window.location.href = '../../view/hutang_piutang.php';
              </script>";
}
$koneksi = null;