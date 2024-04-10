<?php

require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "DELETE FROM jenis_paket WHERE paket_id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    $sql = "DELETE FROM paket WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Paket berhasil dihapus.');
            window.location.href = '../../view/paket.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Paket gagal dihapus');
            window.location.href = '../../view/paket.php';
        </script>";
    }
}
$koneksi = null;