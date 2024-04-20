<?php
$title = "Testimoni";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$tingkat_kepuasan = isset($_GET['tingkat_kepuasan']) ? $_GET['tingkat_kepuasan'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM testimoni";
if ($tingkat_kepuasan != '') {
    $sql .= " WHERE tingkat_kepuasan = :tingkat_kepuasan";
}
$sql .= " LIMIT $limit OFFSET $offset";
$statement = $koneksi->prepare($sql);
if ($tingkat_kepuasan != '') {
    $statement->bindParam(':tingkat_kepuasan', $tingkat_kepuasan);
}
$statement->execute();
$testimoni = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM testimoni";
if ($tingkat_kepuasan != '') {
    $sql .= " WHERE tingkat_kepuasan = :tingkat_kepuasan";
}
$statement = $koneksi->prepare($sql);
if ($tingkat_kepuasan != '') {
    $statement->bindParam(':tingkat_kepuasan', $tingkat_kepuasan);
}
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>

<form method="get">
    <select name="tingkat_kepuasan" class="form-control col-2" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="Puas" <?= $tingkat_kepuasan == 'Puas' ? 'selected' : '' ?>>Puas</option>
        <option value="Tidak Puas" <?= $tingkat_kepuasan == 'Tidak Puas' ? 'selected' : '' ?>>Tidak Puas</option>
        <option value="Biasa Saja" <?= $tingkat_kepuasan == 'Biasa Saja' ? 'selected' : '' ?>>Biasa Saja</option>
    </select>
</form>

<div class="row justify-content-center mb-3">
    <?php foreach ($testimoni as $value): ?>
        <?php
        $sql = "SELECT nama, foto_profil FROM users WHERE id = ?";
        $statement = $koneksi->prepare($sql);
        $statement->execute([$value['user_id']]);
        $user = $statement->fetch();
        ?>
        <div class="col-md-3">
            <div class="card text-center rounded">
                <div class="profile-pic mt-3">
                    <img src="<?= empty($user['foto_profil']) ? '../assets/img/profile.png' : '../db/image/' . $user['foto_profil']; ?>"
                         alt="user-img" width="90" class="img-circle border">
                </div>
                <b class="mt-2"><?= htmlspecialchars($user['nama']) ?></b><small><?= htmlspecialchars($value['tingkat_kepuasan']) ?></small>
                <div class="card-body">
                    <?= htmlspecialchars($value['pesan']); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="testimoni.php?tingkat_kepuasan=<?= $tingkat_kepuasan ?>&page=1">First</a>
        </li>
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="testimoni.php?tingkat_kepuasan=<?= $tingkat_kepuasan ?>&page=<?= max(1, $page - 1) ?>"><</a>
        </li>
        <?php
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="testimoni.php?tingkat_kepuasan=<?= $tingkat_kepuasan ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="testimoni.php?tingkat_kepuasan=<?= $tingkat_kepuasan ?>&page=<?= min($total_pages, $page + 1) ?>">></a>
        </li>
        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="testimoni.php?tingkat_kepuasan=<?= $tingkat_kepuasan ?>&page=<?= $total_pages ?>">Last</a>
        </li>
    </ul>
</nav>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>