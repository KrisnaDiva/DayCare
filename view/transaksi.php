<?php
$title = "Transaksi";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$status = isset($_GET['status']) ? $_GET['status'] : 'dibayar';
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;

if ($status) {
    $sql = "SELECT * FROM transaksi WHERE status = :status";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " AND tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
    $sql .= " LIMIT :limit OFFSET :offset";
} else {
    $sql = "SELECT * FROM transaksi";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " WHERE tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
    $sql .= " LIMIT :limit OFFSET :offset";
}

$statement = $koneksi->prepare($sql);
if ($status) {
    $statement->bindParam(':status', $status);
}
if ($tanggal_awal && $tanggal_akhir) {
    $statement->bindParam(':tanggal_awal', $tanggal_awal);
    $statement->bindParam(':tanggal_akhir', $tanggal_akhir);
}
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$transaksi = $statement->fetchAll();

if ($status) {
    $sql = "SELECT COUNT(*) FROM transaksi WHERE status = :status";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " AND tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
} else {
    $sql = "SELECT COUNT(*) FROM transaksi";
    if ($tanggal_awal && $tanggal_akhir) {
        $sql .= " WHERE tanggal_transaksi BETWEEN :tanggal_awal AND :tanggal_akhir";
    }
}

$statement = $koneksi->prepare($sql);
if ($status) {
    $statement->bindParam(':status', $status);
}
if ($tanggal_awal && $tanggal_akhir) {
    $statement->bindParam(':tanggal_awal', $tanggal_awal);
    $statement->bindParam(':tanggal_akhir', $tanggal_akhir);
}
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);

?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Transaksi</div>
                </div>
                <div class="card-body">
                    <div class="card-options mb-3">
                        <form method="GET" onsubmit="this.page.value = 1">
                            <div class="row">
                                <div class="col-3">
                                    <input type="hidden" name="page" value="<?= $page ?>">
                                    <label for="status">Status</label>
                                    <select name="status" onchange="this.form.page.value = 1; this.form.submit();"
                                            class="form-control">
                                        <option value="" <?= $status == '' ? 'selected' : '' ?>>Semua</option>
                                        <option value="dibayar" <?= $status == 'dibayar' ? 'selected' : '' ?>>Dibayar
                                        </option>
                                        <option value="belum dibayar" <?= $status == 'belum dibayar' ? 'selected' : '' ?>>
                                            Belum
                                            Dibayar
                                        </option>
                                        <option value="dibatalkan" <?= $status == 'dibatalkan' ? 'selected' : '' ?>>
                                            Dibatalkan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="tanggal_awal">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>"
                                           class="form-control">

                                </div>
                                <div class="col-3">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>"
                                           class="form-control">

                                </div>
                                <div class="col-3 d-flex align-items-end ">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <button type="submit" formaction="../db/queries/CetakSemuaTransaksi.php"
                                            class="btn btn-secondary ml-2">Cetak Transaksi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Nama Paket</th>
                            <th>Periode Paket</th>
                            <th>Jenis Paket</th>
                            <th>Pembeli</th>
                            <th>Nama Anak</th>
                            <th>Status</th>
                            <th>Total Bayar</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($transaksi as $key => $value): ?>
                            <?php
                            $sql = "SELECT nama FROM users WHERE id = ?";
                            $statement = $koneksi->prepare($sql);
                            $statement->execute([$value['user_id']]);
                            $pembeli = $statement->fetch();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['id']); ?></td>
                                <td><?= htmlspecialchars($value['nama_paket']) . ' (' . htmlspecialchars($value['usia_paket']) . ')'; ?></td>
                                <td><?= htmlspecialchars($value['periode_paket']); ?></td>
                                <td><?= htmlspecialchars($value['jenis_paket']); ?></td>
                                <td><?= htmlspecialchars($pembeli['nama']) ?></td>
                                <td><?= htmlspecialchars($value['nama_anak']); ?></td>
                                <td><?= htmlspecialchars($value['status']); ?></td>
                                <td>Rp<?= number_format($value['total_bayar'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($value['tanggal_transaksi']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <?php
                    $entries_start = $offset + 1;
                    $entries_end = $offset + count($transaksi);
                    $total_entries = $total_rows;

                    echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>


                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                   href="?status=<?= $status ?>&tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>&page=1">First</a>
                            </li>
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                   href="?status=<?= $status ?>&tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>&page=<?= $page - 1 ?>">&lt;</a>
                            </li>
                            <?php
                            $start = max(1, $page - 2);
                            $end = min($total_pages, $page + 2);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link"
                                                                                              href="?page=<?= $i ?>&status=<?= $status ?>&tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                   href="?status=<?= $status ?>&tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>&page=<?= $page + 1 ?>">&gt;</a>
                            </li>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                   href="?status=<?= $status ?>&tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>&page=<?= $total_pages ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>