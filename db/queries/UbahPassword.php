<?php
require_once __DIR__ . '/../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    $koneksi = getKoneksi();

    $sql = "SELECT password FROM users WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$_SESSION['id']]);

    if ($row = $statement->fetch()) {
        if (password_verify($password_lama, $row['password'])) {
            $password = password_hash($password_baru, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $statement = $koneksi->prepare($sql);
            $statement->execute([$password, $_SESSION['id']]);
            echo "<script type='text/javascript'>
             alert('Password berhasil diubah.');
             window.location.href = '../../view/index.php';
           </script>";
        } else {
            echo "<script type='text/javascript'>
             alert('Password lama salah.');
             window.location.href = '../../view/ubah_password.php';
           </script>";

        }
    }
}