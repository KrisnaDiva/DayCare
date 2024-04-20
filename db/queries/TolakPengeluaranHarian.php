<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_GET['id'];
$statement = $koneksi->prepare("UPDATE pengeluaran SET status = 'ditolak' WHERE id = ?");
$statement->execute([$id]);

if ($statement->rowCount() > 0) {
    echo "<script type='text/javascript'>
                alert('Pengeluaran berhasil ditolak.');
                window.location.href = '../../view/laporan_pengeluaran.php?status=pending';
              </script>";
}else{
    echo "<script type='text/javascript'>
        alert('Pengeluaran gagal ditolak');
        window.location.href = '../../view/laporan_pengeluaran.php?status=pending';
              </script>";
}
$koneksi = null;
