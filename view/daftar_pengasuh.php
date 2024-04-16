<?php
$title = "Pengajar";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM pengasuh";
$statement = $koneksi->prepare($sql);
$statement->execute();
$pengasuh = $statement->fetchAll();
?>


    <div class="row justify-content-center mb-3">
        <?php foreach ($pengasuh as $value): ?>
            <div class="col-md-3">
                <div class="card text-center rounded">
                    <div class="profile-pic mt-3">
                        <img src="<?= empty($value['foto']) ? '../assets/img/profile.png' : '../db/image/' . $value['foto']; ?>"
                             alt="user-img" width="90" class="img-circle border">
                    </div>
                    <b class="mt-2"><?= htmlspecialchars($value['nama']) ?></b>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>