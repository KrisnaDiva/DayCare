<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_POST['id'];
$data = [
    'nama' => $_POST['nama'],
    'usia_minimal' => $_POST['usia_minimal'],
    'usia_maksimal' => $_POST['usia_maksimal'],
];

$fields = implode('=?,', array_keys($data)) . '=?';
$stmt = $koneksi->prepare("UPDATE paket SET $fields WHERE id = $id");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
                alert('Ubah paket berhasil.');
                window.location.href = '../../view/paket.php';
              </script>";
}
$koneksi->rollBack();

echo "<script type='text/javascript'>
        alert('Data paket gagal diubah');
        window.location.href = '../../view/edit_paket.php?id=$id';
              </script>";
$koneksi = null;
