<?php
require_once __DIR__ . '/../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email_baru = $_POST['email'];

    $koneksi = getKoneksi();

    try {
        $koneksi->beginTransaction();

        // Cek email lama
        $sql = "SELECT email FROM users WHERE id = ?";
        $statement = $koneksi->prepare($sql);
        $statement->execute([$_SESSION['id']]);
        $user = $statement->fetch();
        $email_lama = $user['email'];

        // Jika email baru berbeda dengan email lama
        if ($email_baru !== $email_lama) {
            // Cek apakah email baru sudah digunakan
            $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
            $statement = $koneksi->prepare($sql);
            $statement->execute([$email_baru]);
            $count = $statement->fetchColumn();

            // Jika email baru sudah digunakan, lempar exception
            if ($count > 0) {
                throw new Exception("Email sudah digunakan");
            }

            // Update data pengguna
            $sql = "UPDATE users SET nama = ?, jenis_kelamin = ?, nomor_telepon = ?, email = ? WHERE id = ?";
            $statement = $koneksi->prepare($sql);
            $statement->execute([$nama, $jenis_kelamin, $nomor_telepon, $email_baru, $_SESSION['id']]);
        } else {
            // Update data pengguna tanpa mengubah email
            $sql = "UPDATE users SET nama = ?, jenis_kelamin = ?, nomor_telepon = ? WHERE id = ?";
            $statement = $koneksi->prepare($sql);
            $statement->execute([$nama, $jenis_kelamin, $nomor_telepon, $_SESSION['id']]);
        }

        $target_dir = '../image/';

        // Buat direktori jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Cek foto profil lama
        $sql = "SELECT foto_profil FROM users WHERE id = ?";
        $statement = $koneksi->prepare($sql);
        $statement->execute([$_SESSION['id']]);
        $user = $statement->fetch();
        $foto_profil_lama = $user['foto_profil'];

        // Jika ada file foto profil baru yang diupload
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
            $filename = $_FILES['foto_profil']['name'];
            $ukuran = $_FILES['foto_profil']['size'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            // Cek ekstensi dan ukuran file
            if (!in_array($ext, $ekstensi)) {
                throw new Exception("Ekstensi gambar tidak diperbolehkan");
            } else if ($ukuran > 1044070) {
                throw new Exception("Ukuran gambar terlalu besar");
            } else {
                // Hapus foto profil lama jika ada
                if ($foto_profil_lama && file_exists($target_dir . $foto_profil_lama)) {
                    unlink($target_dir . $foto_profil_lama);
                }

                // Upload foto profil baru
                $new_filename = uniqid($_SESSION['id'], true) . 'users' . ".$ext";
                move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_dir . $new_filename);

                // Update data foto profil pengguna
                $sql = "UPDATE users SET foto_profil = ? WHERE id = ?";
                $statement = $koneksi->prepare($sql);
                $statement->execute([$new_filename, $_SESSION['id']]);
            }
        }

        $koneksi->commit();

        // Tampilkan pesan sukses
        echo "<script type='text/javascript'>
        alert('Data Berhasil Diperbarui');
        window.location.href = '../../view/profile.php';
              </script>";
    } catch (Exception $e) {
        $koneksi->rollBack();

        // Tampilkan pesan error
        $errorMessage = $e->getMessage();
        echo "<script type='text/javascript'>
        alert('Data gagal diperbarui $errorMessage');
        window.location.href = '../../view/profile.php';
              </script>";
    } finally {
        $koneksi = null;
    }
}