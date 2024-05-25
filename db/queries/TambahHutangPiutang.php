<?php
require_once __DIR__ . "/../koneksi.php";
$koneksi = getKoneksi();
$data = [
    'tanggal_pinjam' => date('Y-m-d'),
    'jenis' => $_POST['jenis'],
    'status' => 'Belum Lunas',
    'keterangan' => $_POST['keterangan'],
    'total' => $_POST['total']
];
$jenis = $_POST['jenis'];
$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO hutang_piutang ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Tambah $jenis berhasil.');
            window.location.href = '../../view/hutang_piutang.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
        window.location.href = '../../view/tambah_hutang_piutang.php';
      </script>";
}
$koneksi = null;
