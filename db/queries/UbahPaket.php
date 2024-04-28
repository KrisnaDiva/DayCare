<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$koneksi->beginTransaction();
try {
    $id = $_POST['id'];
    $sql = "SELECT * FROM paket WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);
    $paketLama = $statement->fetch();

    $data = [
        'nama' => $_POST['nama'],
        'usia_minimal' => $_POST['usia_minimal'],
        'usia_maksimal' => $_POST['usia_maksimal'],
        'foto' => $paketLama['foto'],
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
            if (file_exists($target_dir . $paketLama['foto'])) {
                unlink($target_dir . $paketLama['foto']);
            }

            $new_filename = uniqid($id, true) . 'paket' . ".$ext";
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_filename);
            $data['foto'] = $new_filename;
        }
    }
    $fields = implode('=?,', array_keys($data)) . '=?';
    $stmt = $koneksi->prepare("UPDATE paket SET $fields WHERE id = $id");

    if ($stmt->execute(array_values($data))) {
        $koneksi->commit();
        echo "<script type='text/javascript'>
                alert('Ubah paket berhasil.');
                window.location.href = '../../view/paket.php';
              </script>";
    }
} catch (Exception $e) {
    $koneksi->rollBack();

    $errorMessage = $e->getMessage();
    echo "<script type='text/javascript'>
        alert('Data paket gagal diubah $errorMessage');
        window.location.href = '../../view/edit_paket.php?id=$id';
              </script>";
} finally {
    $koneksi = null;
}