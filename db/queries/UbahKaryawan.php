<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$koneksi->beginTransaction();
try {
    $id = $_POST['id'];
    $sql = "SELECT * FROM karyawan WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);
    $karyawanLama = $statement->fetch();

    $data = [
        'nama' => $_POST['nama'],
        'posisi' => $_POST['posisi'],
        'gaji' => $_POST['gaji'],
        'email' => $_POST['email'],
        'nomor_telepon' => $_POST['nomor_telepon'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'tanggal_lahir' => $_POST['tanggal_lahir'],
        'tanggal_bergabung' => $_POST['tanggal_bergabung'],
        'pendidikan_terakhir' => $_POST['pendidikan_terakhir'],
    ];

    $fields = implode('=?,', array_keys($data)) . '=?';
    $stmt = $koneksi->prepare("UPDATE karyawan SET $fields WHERE id = $id");

    if ($stmt->execute(array_values($data))) {
        $koneksi->commit();
        echo "<script type='text/javascript'>
                alert('Ubah karyawan berhasil.');
                window.location.href = '../../view/karyawan.php';
              </script>";
    }
} catch (Exception $e) {
    $koneksi->rollBack();

    $errorMessage = $e->getMessage();
    echo "<script type='text/javascript'>
        alert('Data karyawan gagal diubah $errorMessage');
        window.location.href = '../../view/edit_karyawan.php?id=$id';
              </script>";
} finally {
    $koneksi = null;
}
