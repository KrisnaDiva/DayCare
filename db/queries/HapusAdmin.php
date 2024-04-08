<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "DELETE FROM users WHERE id = ? AND role = 'admin'";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Admin berhasil dihapus.');
            window.location.href = '../../view/admin.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Admin gagal dihapus');
            window.location.href = '../../view/admin.php';
        </script>";
    }
}
$koneksi = null;