<?php
require_once __DIR__ . '/../../db/koneksi.php';
$koneksi = getKoneksi();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $tanggal = date('Y-m-d');
    $jam_masuk = date('H:i:s');

    $sql = "INSERT INTO kehadiran (anak_id, tanggal, jam_masuk) VALUES (:id, :tanggal, :jam_masuk)";
    $statement = $koneksi->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
    $statement->bindParam(':jam_masuk', $jam_masuk, PDO::PARAM_STR);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Check In berhasil.');
            window.location.href = '../../view/daftar_anak.php';
          </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Check In gagal.');
            window.location.href = '../../view/daftar_anak.php';
          </script>";
    }
}
$koneksi = null;