<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_POST['id'];
$data = [
    'tanggal' => $_POST['tanggal'],
    'keterangan' => $_POST['keterangan'],
    'total_pengeluaran' => $_POST['total_pengeluaran'],
    'status' => 'pending',
];
$fields = implode('=?,', array_keys($data)) . '=?';
$stmt = $koneksi->prepare("UPDATE pengeluaran SET $fields WHERE id = $id");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
                alert('Perbaiki pengeluaran berhasil.');
                window.location.href = '../../view/pengeluaran.php';
              </script>";
}
echo "<script type='text/javascript'>
        alert('Perbaiki pengeluaran gagal');
        window.location.href = '../../view/perbaiki_pengeluaran_harian.php?id=$id';
              </script>";
$koneksi = null;
