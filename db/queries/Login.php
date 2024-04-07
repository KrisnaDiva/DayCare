<?php
require_once __DIR__ . "/../koneksi.php";

session_start();

$koneksi = getKoneksi();
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$email]);

if ($row = $statement->fetch()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["role"] = $row['role'];
        $_SESSION["login"] = true;
            header("Location: ../../view/index.php");
    } else {
        echo "<script type='text/javascript'>
        alert('Password salah.');
        window.location.href = '../../view/login.php';
      </script>";
    }
} else {
    echo "<script type='text/javascript'>
        alert('Email tidak ditemukan.');
        window.location.href = '../../view/login.php';
      </script>";
}
$koneksi = null;