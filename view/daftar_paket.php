<?php
$title = "Daftar Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$paket = $statement->fetchAll();
?>

    <div class="row justify-content-center mb-3">
        <?php foreach ($paket as $value): ?>
            <div class="col-md-4">
                <div class="card text-center rounded">
                    <img src="../assets/img/profile.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="row justify-content-between px-3">
                        <h5 class="card-title"><?= htmlspecialchars($value['nama']); ?> (<?= htmlspecialchars($value['usia_minimal']); ?> - <?= htmlspecialchars($value['usia_maksimal']); ?> tahun)</h5>
                        <a href="detail_paket.php?id=<?=$value['id'];?>" class="badge badge-primary">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>