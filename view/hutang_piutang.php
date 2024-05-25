<?php
$title = "Transaksi Hutang Piutang";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10; // Define how many records you want to display per page

// Calculate the offset for the query
$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM hutang_piutang";
$countSql = "SELECT COUNT(*) as count FROM hutang_piutang";
$conditions = [];

if ($jenis) {
    $conditions[] = "jenis = :jenis";
}
if ($status) {
    $conditions[] = "status = :status";
}
if ($tanggal_awal && $tanggal_akhir) {
    $conditions[] = "tanggal_pinjam BETWEEN :tanggal_awal AND :tanggal_akhir";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
    $countSql .= " WHERE " . implode(' AND ', $conditions);
}

// Add the limit and offset conditions to the query
$sql .= " LIMIT :perPage OFFSET :offset";

$statement = $koneksi->prepare($sql);
$countStatement = $koneksi->prepare($countSql);

if ($jenis) {
    $statement->bindParam(':jenis', $jenis);
    $countStatement->bindParam(':jenis', $jenis);
}
if ($status) {
    $statement->bindParam(':status', $status);
    $countStatement->bindParam(':status', $status);
}
if ($tanggal_awal && $tanggal_akhir) {
    $statement->bindParam(':tanggal_awal', $tanggal_awal);
    $countStatement->bindParam(':tanggal_awal', $tanggal_awal);
    $statement->bindParam(':tanggal_akhir', $tanggal_akhir);
    $countStatement->bindParam(':tanggal_akhir', $tanggal_akhir);
}

$statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);

$statement->execute();
$hutang_piutang = $statement->fetchAll();

$countStatement->execute();
$count = $countStatement->fetch(PDO::FETCH_ASSOC)['count'];

$totalPages = ceil($count / $perPage);
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between px-3">

                    <div class="card-title">Data Hutang Piutang</div>
                    <div>
                    <a href="tambah_hutang_piutang.php" class="btn btn-primary"><i class="las la-plus"></i> Hutang Piutang</a>
                    </div>
                    </div>

                </div>
                <div class="card-body">
                    <form method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label for="jenis">Jenis</label>
                                <select name="jenis" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="Hutang" <?= $jenis == 'Hutang' ? 'selected' : '' ?>>Hutang</option>
                                    <option value="Piutang" <?= $jenis == 'Piutang' ? 'selected' : '' ?>>Piutang
                                    </option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="Belum Lunas" <?= $status == 'Belum Lunas' ? 'selected' : '' ?>>Belum
                                        Lunas
                                    </option>
                                    <option value="Lunas" <?= $status == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" class="form-control"
                                       value="<?= $tanggal_awal ?>">
                            </div>
                            <div class="col-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control"
                                       value="<?= $tanggal_akhir ?>">
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="submit" formaction="../db/queries/CetakHutangPiutang.php"
                                        class="btn btn-secondary ml-2">Cetak
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Total</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Dibayar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($hutang_piutang as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>Rp<?= number_format($value['total'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($value['jenis']); ?></td>
                                <td><?= htmlspecialchars($value['status']); ?></td>
                                <td><?= htmlspecialchars($value['keterangan']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_pinjam']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_dibayar']); ?></td>
                               <?php if ($value['status'] == 'Belum Lunas'): ?>
                                <td>
                                    <a href="../db/queries/BayarHutangPiutang.php?id=<?= $value['id'] ?>" class="btn btn-success">Bayar</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="card-footer">
                        <?php
                        $entries_start = $offset + 1;
                        $entries_end = $offset + count($hutang_piutang);
                        $total_entries = $count;

                        echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>
                    </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Rest of the code remains the same -->

<?php
// Get current query parameters
$query_params = $_GET;

// Pagination links
$pagination_links = [
    'first' => 1,
    'prev' => max(1, $page - 1),
    'next' => min($totalPages, $page + 1),
    'last' => $totalPages
];

foreach ($pagination_links as $key => $value) {
    // Update the 'page' query parameter
    $query_params['page'] = $value;

    // Build the query string
    $query_string = http_build_query($query_params);

    // Generate the pagination link
    $pagination_links[$key] = '?' . $query_string;
}
?>

    <!-- Rest of the code remains the same -->

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pagination_links['first'] ?>">First</a>
            </li>
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pagination_links['prev'] ?>">&lt;</a>
            </li>
            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            for ($i = $start; $i <= $end; $i++):
                // Update the 'page' query parameter
                $query_params['page'] = $i;

                // Build the query string
                $query_string = http_build_query($query_params);
                ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= $query_string ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pagination_links['next'] ?>">&gt;</a>
            </li>
            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pagination_links['last'] ?>">Last</a>
            </li>
        </ul>
    </nav>

    <!-- Rest of the code remains the same -->
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>