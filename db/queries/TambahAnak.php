<?php
require_once __DIR__ . "/../koneksi.php";
session_start();
$koneksi = getKoneksi();
$data = [
    'nama' => $_POST['nama'],
    'tanggal_lahir' => $_POST['tanggal_lahir'],
    'jenis_kelamin' => $_POST['jenis_kelamin'],
    'user_id' => $_SESSION['id']
];

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO anak ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah anak berhasil.');
            window.location.href = '../../view/anak.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_anak.php';
      </script>";
}
$koneksi = null;
