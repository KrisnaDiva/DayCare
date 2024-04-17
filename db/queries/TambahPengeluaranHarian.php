<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$data = [
    'tanggal' => $_POST['tanggal'],
    'keterangan' => $_POST['keterangan'],
    'total_pengeluaran' => $_POST['total_pengeluaran'],
    'status' => 'pending',
];
$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO pengeluaran ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah Pengeluaran berhasil.');
            window.location.href = '../../view/pengeluaran.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_pengeluaran_harian.php?date={$_POST['tanggal']}';
      </script>";
}
$koneksi = null;

