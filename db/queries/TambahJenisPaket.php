<?php
require_once __DIR__ . "/../koneksi.php";
$koneksi = getKoneksi();
$data = [
    'periode' => $_POST['periode'],
    'jenis' => $_POST['jenis'],
    'harga' => $_POST['harga'],
    'paket_id' => $_POST['paket_id']
];

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO jenis_paket ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah jenis paket berhasil.');
            window.location.href = '../../view/jenis_paket.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_jenis_paket.php';
      </script>";
}
$koneksi = null;
