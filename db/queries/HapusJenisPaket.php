<?php

require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "DELETE FROM jenis_paket WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Jenis Paket berhasil dihapus.');
            window.location.href = '../../view/jenis_paket.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Jenis Paket gagal dihapus');
            window.location.href = '../../view/jenis_paket.php';
        </script>";
    }
}
$koneksi = null;