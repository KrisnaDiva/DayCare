<?php
require_once __DIR__ . "/../koneksi.php";

session_start();
$koneksi = getKoneksi();
$id = $_POST['id'];

$jenis_pengeluaran = array_filter($_POST, function ($key) {
    return strpos($key, 'jenis_pengeluaran') === 0;
}, ARRAY_FILTER_USE_KEY);

$pengeluaran = array_filter($_POST, function ($key) {
    return strpos($key, 'pengeluaran') === 0;
}, ARRAY_FILTER_USE_KEY);

$total_pengeluaran = array_sum($pengeluaran); // Menghitung total pengeluaran
$data = [
    'tanggal' => $_POST['tanggal'],
    'keterangan' => $_POST['keterangan'],
    'total_pengeluaran' => $total_pengeluaran,
    'status' => 'pending',
    'user_id' => $_SESSION['id']
];

try {
    // Mulai transaksi
    $koneksi->beginTransaction();

    $fields = implode('=?,', array_keys($data)) . '=?';
    $stmt = $koneksi->prepare("UPDATE pengeluaran SET $fields WHERE id = $id");
    $stmt->execute(array_values($data));

    $sql = "DELETE FROM detail_pengeluaran WHERE pengeluaran_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$id]);

    for ($i = 0; $i < count($jenis_pengeluaran); $i++) {
        $sql = "INSERT INTO detail_pengeluaran (pengeluaran,jenis_pengeluaran,  pengeluaran_id) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$pengeluaran["pengeluaran$i"], $jenis_pengeluaran["jenis_pengeluaran$i"], $id]);
    }

    // Jika semua operasi berhasil, commit transaksi
    $koneksi->commit();

    echo "<script type='text/javascript'>
                alert('Perbaiki pengeluaran berhasil.');
                window.location.href = '../../view/pengeluaran.php';
              </script>";
} catch (Exception $e) {
    // Jika ada kesalahan, rollback transaksi
    $koneksi->rollBack();

    echo "<script type='text/javascript'>
        alert('`{${$e->getMessage()}}`');
        window.location.href = '../../view/perbaiki_pengeluaran_harian.php?id=$id';
      </script>";
}