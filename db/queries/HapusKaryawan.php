<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $koneksi = getKoneksi();

    $sql = "DELETE FROM karyawan WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Karyawan berhasil dihapus.');
            window.location.href = '../../view/karyawan.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Karyawan gagal dihapus');
            window.location.href = '../../view/karyawan.php';
        </script>";
    }
}
$koneksi = null;