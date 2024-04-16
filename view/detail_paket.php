<?php
$title = "Detail Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM jenis_paket WHERE paket_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$jenis_paket = $statement->fetchAll();

$sql = "SELECT * FROM paket WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$paket = $statement->fetch();
?>
    <div class="row justify-content-center mb-3">
        <?php foreach ($jenis_paket as $value): ?>
            <div class="col-md-4">
                <div class="card text-center rounded">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($paket['nama']); ?>
                            (<?= htmlspecialchars($paket['usia_minimal']); ?>
                            - <?= htmlspecialchars($paket['usia_maksimal']); ?> tahun)</h5>
                        <p>Periode : <?= htmlspecialchars($value['periode']); ?></p>
                        <p>Jenis : <?= htmlspecialchars($value['jenis']); ?></p>
                        <p>Harga : Rp<?= number_format($value['harga'], 0, ',', '.'); ?></p></div>
                    <div class="card-footer">
                        <a href="checkout.php?id=<?= $value['id']; ?>" class="btn btn-primary">Claim</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>