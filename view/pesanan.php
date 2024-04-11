<?php
$title = "Checkout";
ob_start();
session_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$status = isset($_GET['status']) ? $_GET['status'] : 'dibayar';
$sql = "SELECT * From transaksi where user_id = ? AND status = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id'], $status]);
$pending = $statement->fetchAll();
?>

    <ul class="nav nav-tabs justify-content-center mb-5">
        <li class="nav-item">
            <a class="nav-link <?= $status == 'dibayar' ? 'active' : '' ?>"
               href="pesanan.php?status=dibayar">Dibayar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $status == 'belum dibayar' ? 'active' : '' ?>"
               href="pesanan.php?status=belum%20dibayar">Belum Dibayar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $status == 'dibatalkan' ? 'active' : '' ?>" href="pesanan.php?status=dibatalkan">Dibatalkan</a>
        </li>
    </ul>
    <div class="row justify-content-center">

<?php foreach ($pending as $value): ?>
    <?php
    $sql = "SELECT * From anak where id = ? ";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$value['anak_id']]);
    $anak = $statement->fetch();

    $sql = "SELECT * From jenis_paket where id = ? ";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$value['jenis_paket_id']]);
    $jenis_paket = $statement->fetch();

    $sql = "SELECT * FROM paket where id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$jenis_paket['paket_id']]);
    $paket = $statement->fetch();
    ?>
    <div class="col-10">
        <div class="card ">

            <div class="card-body">
                <div class="row justify-content-between px-5 mb-3">
                    <small class="text-muted"> <?= date("d-m-Y H:i", strtotime($value['tanggal_transaksi'])) ?></small>
                    <?php if ($value['status'] == 'belum dibayar'): ?>
                        <small class="text-muted">Bayar
                            Sebelum <?= date("d-m-Y H:i", strtotime($value['tanggal_transaksi'] . '+1 day')) ?></small>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="row text-center mb-3 font-weight-bold">
                    <div class="col-2">
                        Nama Paket
                    </div>
                    <div class="col-2">
                        Periode
                    </div>
                    <div class="col-2">
                        Jenis
                    </div>
                    <div class="col-2">
                        Anak
                    </div>
                    <div class="col-2">
                        Harga
                    </div>
                    <div class="col-2">
                        Status
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-2">
                        <?= htmlspecialchars($paket['nama']); ?> (<?= htmlspecialchars($paket['usia_minimal']); ?>
                        - <?= htmlspecialchars($paket['usia_maksimal']); ?> tahun)
                    </div>
                    <div class="col-2">
                        <?= $jenis_paket['periode']; ?>
                    </div>
                    <div class="col-2">
                        <?= $jenis_paket['jenis']; ?>
                    </div>
                    <div class="col-2">
                        <?= $anak['nama']; ?>
                    </div>
                    <div class="col-2">
                        <?= 'Rp' . number_format($value['total_bayar'], 0, ',', '.'); ?>                    </div>
                    <div class="col-2">
                        <?= $value['status']; ?>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-end px-5">
                    <?php if ($value['status'] == 'belum dibayar'): ?>
                        <a href="javascript:if(confirm('Apakah anda yakin mau membatalkan pesanan?')) window.location.href='../db/queries/BayarDanBatal.php?id=<?= $value['id'] ?>&status=dibatalkan';"
                           class="btn btn-danger">Batal</a>
                        <button type="submit" id="pay-button-<?= $value['id'] ?>" class="btn btn-success ml-3">Bayar
                        </button>
                    <?php elseif ($value['status'] == 'dibayar'): ?>
                        <a href="../db/queries/CetakTransaksi.php?id=<?= $value['id'] ?>" class="btn btn-primary ml-3">Cetak
                            Detail
                            Transaksi</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?php echo 'SB-Mid-client-DydJ4fTsGZX-Vzzk' ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button-<?= $value['id'] ?>').onclick = function () {
            snap.pay('<?php echo $value['snap_token']?>', {
                onSuccess: function (result) {
                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.open("GET", "../db/queries/BayarDanBatal.php?id=<?= $value['id'] ?>&status=dibayar");
                    xmlhttp.send();
                    alert('Transaksi Berhasil');
                    window.location.href = 'pesanan.php';
                }
            });
        };
    </script>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>