<?php
$title = "Anak";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM anak WHERE nama LIKE :search LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$anak = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM anak WHERE nama LIKE :search";
$statement = $koneksi->prepare($sql);
$statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM kehadiran WHERE DATE(tanggal) = CURDATE()";
$statement = $koneksi->prepare($sql);
$statement->execute();
$kehadiran = $statement->fetchAll();

$kehadiran_ids = array_column($kehadiran, 'id');
$anak_ids = array_column($kehadiran, 'anak_id');
?>
    <div class="row justify-content-center mb-3">
        <ul class="nav nav-tabs justify-content-center mb-5">
            <li class="nav-item">
                <a class="nav-link active" href="daftar_anak.php">Daftar Anak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kehadiran.php">Kehadiran</a>
            </li>
        </ul>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Anak</div>
                </div>
                <div class="card-body text-right">
                    <form method="GET" class="form-inline mb-3">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                               name="search" value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($anak as $key => $value): ?>
                            <?php
                            $sql = "SELECT nama FROM anak WHERE id = :id";
                            $statement = $koneksi->prepare($sql);
                            $statement->bindParam(':id', $value['id']);
                            $statement->execute();
                            $anak = $statement->fetch();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($anak['nama']); ?></td>
                                <td><?= htmlspecialchars($value['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_lahir']); ?></td>
                                <td style="display: inline-block;">
                                    <?php
                                    $anak_id = $value['id'];
                                    $key = array_search($anak_id, $anak_ids);

                                    if ($key === false) {
                                        ?>
                                        <a href="../db/queries/CheckIn.php?id=<?= $anak_id; ?>" class="btn btn-success"
                                           style="display: inline-block;"><i class="las la-sign-in-alt"></i> Check
                                            In</a>
                                        <?php
                                    } else if ($kehadiran[$key]['jam_masuk'] !== null && $kehadiran[$key]['jam_keluar'] === null) {
                                        $kehadiran_id = $kehadiran_ids[$key];
                                        ?>
                                        <a href="../db/queries/CheckOut.php?id=<?= $kehadiran_id; ?>"
                                           class="btn btn-danger"
                                           style="display: inline-block;"><i class="las la-sign-out-alt"></i> Check Out</a>
                                        <?php
                                    } else if ($kehadiran[$key]['jam_masuk'] !== null && $kehadiran[$key]['jam_keluar'] !== null) {
                                        echo "";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <?php
                    $entries_start = $offset + 1;
                    $entries_end = $offset + count($anak);
                    $total_entries = $total_rows;

                    echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?page=1&search=<?= urlencode($search) ?>">First</a>
                            </li>
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><</a>
                            </li>
                            <?php
                            $num_links_to_display = 2;
                            $start = max(1, $page - $num_links_to_display);
                            $end = min($total_pages, $page + $num_links_to_display);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link"
                                                                                              href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">></a>
                            </li>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- Rest of your code... -->                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>