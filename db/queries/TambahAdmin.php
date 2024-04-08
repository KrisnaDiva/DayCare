<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$data = [
    'nama' => $_POST['nama'],
    'email' => $_POST['email'],
    'nomor_telepon' => $_POST['nomor_telepon'],
    'jenis_kelamin' => $_POST['jenis_kelamin'],
    'role' => 'admin',
    'password' => password_hash('password', PASSWORD_DEFAULT)
];

$stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data['email']]);
if ($stmt->rowCount() > 0) {
    echo "<script type='text/javascript'>
        alert('Email sudah terdaftar.');
        window.location.href = '../../view/tambah_admin.php';
      </script>";
}

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO users ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah admin berhasil.');
            window.location.href = '../../view/admin.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_admin.php';
      </script>";
}
$koneksi = null;
