<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_POST['id'];
$data = [
    'nama' => $_POST['nama'],
    'jenis_kelamin' => $_POST['jenis_kelamin'],
    'tanggal_lahir' => $_POST['tanggal_lahir'],
];

$fields = implode('=?,', array_keys($data)) . '=?';
$stmt = $koneksi->prepare("UPDATE anak SET $fields WHERE id = $id");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
                alert('Ubah anak berhasil.');
                window.location.href = '../../view/anak.php';
              </script>";
}
$koneksi->rollBack();

echo "<script type='text/javascript'>
        alert('Data anak gagal diubah');
        window.location.href = '../../view/edit_anak.php?id=$id';
              </script>";
$koneksi = null;
