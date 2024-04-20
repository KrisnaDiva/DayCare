<?php
$title = "Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM paket LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$paket = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs justify-content-center mb-5">
                <li class="nav-item">
                    <a class="nav-link active" href="paket.php">Daftar Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jenis_paket.php">Jenis Paket</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Paket</div>
                </div>
                <div class="card-body text-right">
                    <a href="tambah_paket.php" class="btn btn-primary mb-3 mr-3"><i class="las la-plus"></i> Paket</a>

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Usia Minimal</th>
                            <th>Usia Maksimal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($paket as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['nama']); ?></td>
                                <td>
                                    <img src="../db/image/<?= htmlspecialchars($value['foto']); ?>" alt="Foto Profil"
                                         width="50" height="50">
                                </td>
                                <td><?= htmlspecialchars($value['usia_minimal']); ?></td>
                                <td><?= htmlspecialchars($value['usia_maksimal']); ?></td>
                                <td style="display: inline-block;">
                                    <a href="edit_paket.php?id=<?= $value['id']; ?>" class="btn btn-warning"
                                       style="display: inline-block;"><i class="las la-edit"></i></a>

                                    <form method="POST" action="../db/queries/HapusPaket.php"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini? Menghapus paket juga akan menghapus jenis paket yang terkait.');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger"><i class="las la-trash"></i>
                                        </button>
                                    </form>
                                    <a href="tambah_jenis_paket.php?id=<?= $value['id']; ?>" class="btn btn-primary"><i
                                                class="las la-plus"></i> Jenis</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <?php
                    $entries_start = $offset + 1;
                    $entries_end = $offset + count($paket);
                    $total_entries = $total_rows;

                    echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?page=1">First</a></li>
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?page=<?= $page - 1 ?>"><</a>
                            </li>
                            <?php
                            $start = max(1, $page - 2);
                            $end = min($total_pages, $page + 2);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link"
                                                                                              href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?page=<?= $page + 1 ?>">></a>
                            </li>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?page=<?= $total_pages ?>">Last</a>
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