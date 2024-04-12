<?php
require_once __DIR__ . "/../koneksi.php";
session_start();
$koneksi = getKoneksi();
$koneksi->beginTransaction();
try {
    $data = [
        'nama' => $_POST['nama'],
        'usia_minimal' => $_POST['usia_minimal'],
        'usia_maksimal' => $_POST['usia_maksimal']
    ];
    $target_dir = '../image/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
        $filename = $_FILES['foto']['name'];
        $ukuran = $_FILES['foto']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $ekstensi)) {
            throw new Exception("Ekstensi gambar tidak diperbolehkan");
        } else if ($ukuran > 1044070) {
            throw new Exception("Ukuran gambar terlalu besar");
        } else {
            $new_filename = uniqid($_SESSION['id'], true) . 'paket' . ".$ext";
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_filename);
            $data['foto'] = $new_filename;
        }
    }

    $placeholders = str_repeat('?,', count($data) - 1) . '?';
    $fields = implode(',', array_keys($data));
    $stmt = $koneksi->prepare("INSERT INTO paket ($fields) VALUES ($placeholders)");

    if ($stmt->execute(array_values($data))) {
        $koneksi->commit();
        echo "<script type='text/javascript'>
            alert('Tambah paket berhasil.');
            window.location.href = '../../view/paket.php';
          </script>";
    }
} catch (Exception $e) {
    $koneksi->rollBack();

    $errorMessage = $e->getMessage();
    echo "<script type='text/javascript'>
        alert('Data gagal ditambahkan $errorMessage');
        window.location.href = '../../view/tambah_paket.php';
              </script>";
} finally {
    $koneksi = null;
}

