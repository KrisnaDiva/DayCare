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
<style>
    .card-header {
    height:400px; /* Atur tinggi sesuai kebutuhan Anda */
    width: 100%; /* Atur lebar sesuai kebutuhan Anda */
    overflow: hidden; /* Memastikan bagian gambar yang berlebihan dipotong */
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Gambar akan menutupi seluruh area yang ditentukan */
}
</style>
    <div class="row justify-content-center mb-3">
        <?php foreach ($paket as $value): ?>
            <div class="col-md-4">
                <div class="card text-center rounded">
                    <div class="card-header">
<img src="<?= empty($value['foto']) ? '../assets/img/profile.png' : "../db/image/" . htmlspecialchars($value['foto']); ?>" class="card-img-top" alt="...">                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between px-3">
                            <h5 class="card-title"><?= htmlspecialchars($value['nama']); ?>
                                (<?= htmlspecialchars($value['usia_minimal']); ?>
                                - <?= htmlspecialchars($value['usia_maksimal']); ?> tahun)</h5>
                            <a href="detail_paket.php?id=<?= $value['id']; ?>" class="badge badge-primary">Detail</a>
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