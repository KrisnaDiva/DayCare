<?php
require_once __DIR__ . '/../../db/koneksi.php';
$koneksi = getKoneksi();

$kehadiran_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($kehadiran_id) {
    $jam_keluar = date('H:i:s');

    $sql = "UPDATE kehadiran SET jam_keluar = :jam_keluar WHERE id = :id";
    $statement = $koneksi->prepare($sql);
    $statement->bindParam(':jam_keluar', $jam_keluar, PDO::PARAM_STR);
    $statement->bindParam(':id', $kehadiran_id, PDO::PARAM_INT);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Check Out berhasil.');
            window.location.href = '../../view/daftar_anak.php';
          </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Check Out gagal.');
            window.location.href = '../../view/daftar_anak.php';
          </script>";
    }
}
$koneksi = null;