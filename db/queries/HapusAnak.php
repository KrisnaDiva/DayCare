<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "UPDATE anak SET is_deleted = 1 WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Anak berhasil dihapus.');
            window.location.href = '../../view/anak.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Anak gagal dihapus');
            window.location.href = '../../view/anak.php';
        </script>";
    }
}
$koneksi = null;