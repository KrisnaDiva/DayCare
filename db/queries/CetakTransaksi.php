<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../db/koneksi.php';

$koneksi = getKoneksi();
$id = $_GET['id'];

$sql = "SELECT * From transaksi where id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$transaksi = $statement->fetch();

$sql = "SELECT nama FROM users where id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$transaksi['user_id']]);
$user = $statement->fetch();

$tanggal_transaksi = date("d-m-Y", strtotime($transaksi['tanggal_transaksi']));

$html = "
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }
     .small-column {
        width: 20%; /* Ubah sesuai kebutuhan */
    }
    </style>
<h1>Detail Transaksi</h1>

<table border='0'>
    <tr>
       <td>ID Transaksi : {$transaksi['id']}</td>
<td style='text-align: right;'>Tanggal Transaksi : {$tanggal_transaksi}</td>
</tr>    
</table>
<br>
<h4>Rincian Pesanan</h4>
<table border='0'>
    <tbody>
   
        <tr>
            <td class='small-column'>Pembeli :</td>
            <td>{$user['nama']}</td>
        </tr>
        <tr>
            <td>Nama Anak :</td>
            <td>{$transaksi['nama_anak']}</td>
        </tr>
        <tr>
            <td>Nama Paket :</td>
            <td>{$transaksi['nama_paket']} ({$transaksi['usia_paket']})</td>
        </tr>
        <tr>
            <td>Jenis Paket :</td>
            <td>{$transaksi['jenis_paket']}</td>
        </tr>
        <tr>
            <td>Periode Paket :</td>
            <td>{$transaksi['periode_paket']}</td>
        </tr>
        <tr>
            <td>Total Bayar :</td>
            <td>Rp" . number_format($transaksi['total_bayar'], 0, ',', '.') . "</td>
        </tr>
        <tr>
            <td>Status :</td>
            <td>{$transaksi['status']}</td>
        </tr>
    </tbody>
</table>
";
$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);

$mpdf->Output('Detail Transaksi.pdf', 'I');