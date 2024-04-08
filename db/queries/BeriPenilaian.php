<?php
require_once __DIR__ . "/../koneksi.php";
session_start();
$koneksi = getKoneksi();
$data = [
    'tingkat_kepuasan' => $_POST['tingkat_kepuasan'],
    'pesan' => $_POST['pesan'],
    'user_id' => $_SESSION['id']
];

$stmt = $koneksi->prepare("SELECT * FROM testimoni WHERE user_id = ?");
$stmt->execute([$data['user_id']]);
if ($stmt->rowCount() > 0) {
    $stmt = $koneksi->prepare("UPDATE testimoni SET tingkat_kepuasan = ?, pesan = ? WHERE user_id = ?");
    if ($stmt->execute([$data['tingkat_kepuasan'], $data['pesan'], $data['user_id']])) {
        echo "<script type='text/javascript'>
                alert('Update Penilaian Berhasil.');
                window.location.href = '../../view/index.php';
              </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('`{${$stmt->errorInfo()[2]}}`');
            window.location.href = '../../view/beri_penilaian.php';
          </script>";
    }
} else {
    $placeholders = str_repeat('?,', count($data) - 1) . '?';
    $fields = implode(',', array_keys($data));
    $stmt = $koneksi->prepare("INSERT INTO testimoni ($fields) VALUES ($placeholders)");

    if ($stmt->execute(array_values($data))) {
        echo "<script type='text/javascript'>
                alert('Beri Penilaian Berhasil.');
                window.location.href = '../../view/index.php';
              </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('`{${$stmt->errorInfo()[2]}}`');
            window.location.href = '../../view/beri_penilaian.php';
          </script>";
    }
}
$koneksi = null;

