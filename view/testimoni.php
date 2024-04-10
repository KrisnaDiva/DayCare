<?php
$title = "Testimoni";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM testimoni";
$statement = $koneksi->prepare($sql);
$statement->execute();
$testimoni = $statement->fetchAll();
?>


    <div class="row justify-content-center mb-3">
        <?php foreach ($testimoni as $value): ?>
            <?php
            $sql = "SELECT nama, foto_profil FROM users WHERE id = ?";
            $statement = $koneksi->prepare($sql);
            $statement->execute([$value['user_id']]);
            $statement->execute([$value['user_id']]);
            $user = $statement->fetch();
            ?>
            <div class="col-md-3">
                <div class="card text-center rounded">
                    <div class="profile-pic mt-3">
                        <img src="<?= empty($user['foto_profil']) ? '../assets/img/profile.png' : '../db/image/' . $user['foto_profil']; ?>"
                             alt="user-img" width="90" class="img-circle border">
                    </div>
                    <b class="mt-2"><?= htmlspecialchars($user['nama']) ?></b>
                    <div class="card-body">
                        <?= htmlspecialchars($value['pesan']); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>