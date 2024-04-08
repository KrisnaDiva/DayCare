<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "DELETE FROM pengasuh WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Pengasuh berhasil dihapus.');
            window.location.href = '../../view/pengasuh.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Pengasuh gagal dihapus');
            window.location.href = '../../view/pengasuh.php';
        </script>";
    }
}
$koneksi = null;