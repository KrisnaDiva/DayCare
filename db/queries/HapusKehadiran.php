<?php
require_once __DIR__ . '/../koneksi.php';
$koneksi = getKoneksi();

$id = $_POST['id'];
$sql = "DELETE FROM kehadiran WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);

if ($statement->rowCount() > 0) {
    echo "<script type='text/javascript'>
            alert('Hapus Kehadiran Berhasil.');
            window.location.href = '../../view/kehadiran.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Hapus Kehadiran Gagal.');
            window.location.href = '../../view/kehadiran.php';
          </script>";
}
$koneksi = null;