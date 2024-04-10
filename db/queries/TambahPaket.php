<?php
require_once __DIR__ . "/../koneksi.php";
$koneksi = getKoneksi();
$data = [
    'nama' => $_POST['nama'],
    'usia_minimal' => $_POST['usia_minimal'],
    'usia_maksimal' => $_POST['usia_maksimal']
];

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO paket ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah paket berhasil.');
            window.location.href = '../../view/paket.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_paket.php';
      </script>";
}
$koneksi = null;
