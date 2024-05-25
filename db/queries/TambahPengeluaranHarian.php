<?php
require_once __DIR__ . "/../koneksi.php";

session_start();
$koneksi = getKoneksi();

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

    $placeholders = str_repeat('?,', count($data) - 1) . '?';
    $fields = implode(',', array_keys($data));
    $stmt = $koneksi->prepare("INSERT INTO pengeluaran ($fields) VALUES ($placeholders)");
    $stmt->execute(array_values($data));

    $pengeluaran_id = $koneksi->lastInsertId();

    for ($i = 1; $i <= count($jenis_pengeluaran); $i++) {
        $sql = "INSERT INTO detail_pengeluaran (pengeluaran,jenis_pengeluaran,  pengeluaran_id) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$pengeluaran["pengeluaran$i"], $jenis_pengeluaran["jenis_pengeluaran$i"], $pengeluaran_id]);
    }

    // Jika semua operasi berhasil, commit transaksi
    $koneksi->commit();

    echo "<script type='text/javascript'>
            alert('Tambah PengeluaranHarian berhasil.');
            window.location.href = '../../view/pengeluaran.php';
          </script>";
} catch (Exception $e) {
    // Jika ada kesalahan, rollback transaksi
    $koneksi->rollBack();

    echo "<script type='text/javascript'>
        alert('`{${$e->getMessage()}}`');
        window.location.href = '../../view/tambah_pengeluaran_harian.php?date={$_POST['tanggal']}';
      </script>";
}