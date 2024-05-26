<?php
require_once __DIR__ . '/../../db/koneksi.php';
$koneksi = getKoneksi();

$periode = $_GET['periode'];
$nama_karyawan = array_filter($_POST, function ($key) {
    return strpos($key, 'nama_karyawan') === 0;
}, ARRAY_FILTER_USE_KEY);
$gaji_pokok = array_filter($_POST, function ($key) {
    return strpos($key, 'gaji_pokok') === 0;
}, ARRAY_FILTER_USE_KEY);

$tunjangan = array_filter($_POST, function ($key) {
    return strpos($key, 'tunjangan') === 0;
}, ARRAY_FILTER_USE_KEY);

try {
    $koneksi->beginTransaction();
    $tanggal_bayar = date('Y-m-d');

    $stmt = $koneksi->prepare("INSERT INTO penggajian (periode, tanggal_bayar, total) VALUES (?, ?, ?)");
    $stmt->execute([$periode, $tanggal_bayar, 0]);

    $penggajian_id = $koneksi->lastInsertId();

    $total = 0;

    for ($i = 1; $i <= count($nama_karyawan); $i++) {
        $nama = $nama_karyawan["nama_karyawan$i"] ?? 0;
        $gaji = $gaji_pokok["gaji_pokok$i"] ?? 0;
        $tunjangan_value = $tunjangan["tunjangan$i"] ?? 0;

        $total += (int)$gaji + (int)$tunjangan_value;
        $sql = "INSERT INTO detail_penggajian (nama_karyawan, gaji_pokok, tunjangan, penggajian_id) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$nama, $gaji, $tunjangan_value, $penggajian_id]);
    }

    $sql = "UPDATE penggajian SET total = ? WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$total, $penggajian_id]);
    $koneksi->commit();

    echo "<script type='text/javascript'>
            alert('Pembayaran Gaji Berhasil.');
            window.location.href = '../../view/penggajian.php';
          </script>";
} catch (Exception $e) {
    $koneksi->rollBack();

    echo "<script type='text/javascript'>
        alert('`{${$e->getMessage()}}`');
        window.location.href = '../../view/bayar_gaji.php?periode=$periode';
      </script>";
}