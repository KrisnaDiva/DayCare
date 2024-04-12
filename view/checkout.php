<?php
$title = "Checkout";
ob_start();
session_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM jenis_paket where id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$jenis_paket = $statement->fetch();

$periode = htmlspecialchars($jenis_paket['periode']);
$jenis = htmlspecialchars($jenis_paket['jenis']);
$harga = htmlspecialchars($jenis_paket['harga']);

$sql = "SELECT * FROM paket where id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$jenis_paket['paket_id']]);
$paket = $statement->fetch();

$sql = "SELECT * FROM anak WHERE user_id = ? AND TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id'], $paket['usia_minimal'], $paket['usia_maksimal']]);
$anak = $statement->fetchAll();
?>

    <div class="row justify-content-center">
    <div class="col-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Pesanan</div>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3 font-weight-bold">
                    <div class="col-3">
                        Nama Paket
                    </div>
                    <div class="col-3">
                        Periode
                    </div>
                    <div class="col-3">
                        Jenis
                    </div>
                    <div class="col-3">
                        Harga
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-3">
                        <?= htmlspecialchars($paket['nama']); ?> (<?= htmlspecialchars($paket['usia_minimal']); ?>
                        - <?= htmlspecialchars($paket['usia_maksimal']); ?> tahun)
                    </div>
                    <div class="col-3">
                        <?= $periode; ?>
                    </div>
                    <div class="col-3">
                        <?= $jenis; ?>
                    </div>
                    <div class="col-3">
                        Rp<?= number_format($harga, 0, ',', '.'); ?>                    </div>
                </div>
                <hr>
                <form action="../db/queries/Beli.php" method="post">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="row">
                        <div class="col-1  d-flex align-items-center justify-content-end">
                            <label for="anak">Anak:</label>
                        </div>
                        <div class="col-5">
                            <select class="form-control" name="anak" id="anak" required>
                                <option selected value="">Pilih anak</option>
                                <?php foreach ($anak as $a) : ?>
                                    <option value="<?= htmlspecialchars($a['id']); ?>">
                                        <?= htmlspecialchars($a['nama']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success">Beli</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $('form').on('submit', function () {
            $(this).find('button[type="submit"]').prop('disabled', true);
        });
    </script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>