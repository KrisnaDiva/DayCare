<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$id = $_POST['id'];
$data = [
    'periode' => $_POST['periode'],
    'jenis' => $_POST['jenis'],
    'harga' => $_POST['harga'],
    'paket_id' => $_POST['paket_id']
];

$fields = implode('=?,', array_keys($data)) . '=?';
$stmt = $koneksi->prepare("UPDATE jenis_paket SET $fields WHERE id = $id");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
                alert('Ubah jenis paket berhasil.');
                window.location.href = '../../view/jenis_paket.php';
              </script>";
}
$koneksi->rollBack();

echo "<script type='text/javascript'>
        alert('Data jenis paket gagal diubah');
        window.location.href = '../../view/edit_jenis_paket.php?id=$id';
              </script>";
$koneksi = null;
