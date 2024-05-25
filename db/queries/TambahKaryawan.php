<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$koneksi->beginTransaction();
try {
    $data = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'posisi' => $_POST['posisi'],
        'gaji' => $_POST['gaji'],
        'nomor_telepon' => $_POST['nomor_telepon'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'tanggal_lahir' => $_POST['tanggal_lahir'],
        'pendidikan_terakhir' => $_POST['pendidikan_terakhir'],
        'tanggal_bergabung' => $_POST['tanggal_bergabung'],
    ];

    if ($data['posisi'] == 'Admin') {
        $adminData = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'nomor_telepon' => $data['nomor_telepon'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'role' => 'admin',
            'password' => password_hash('password', PASSWORD_DEFAULT)
        ];

        $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$adminData['email']]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Email sudah terdaftar.');
        }
        $placeholders = str_repeat('?,', count($adminData) - 1) . '?';
        $fields = implode(',', array_keys($adminData));
        $stmt = $koneksi->prepare("INSERT INTO users ($fields) VALUES ($placeholders)");
        $stmt->execute(array_values($adminData));
    }
    $placeholders = str_repeat('?,', count($data) - 1) . '?';
    $fields = implode(',', array_keys($data));
    $stmt = $koneksi->prepare("INSERT INTO karyawan ($fields) VALUES ($placeholders)");

    if ($stmt->execute(array_values($data))) {
        $koneksi->commit();
        echo "<script type='text/javascript'>
                alert('Tambah karyawan berhasil.');
                window.location.href = '../../view/karyawan.php';
              </script>";
    }
} catch (Exception $e) {
    $koneksi->rollBack();

    $errorMessage = $e->getMessage();
    echo "<script type='text/javascript'>
        alert('Data gagal ditambahkan $errorMessage');
        window.location.href = '../../view/tambah_karyawan.php';
              </script>";
} finally {
    $koneksi = null;
}