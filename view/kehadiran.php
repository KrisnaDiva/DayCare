<?php
$title = "Kehadiran";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
$sql = "SELECT * FROM kehadiran WHERE DATE(tanggal) = :tanggal LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindValue(':tanggal', $tanggal, PDO::PARAM_STR);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$kehadiran = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM kehadiran WHERE DATE(tanggal) = :tanggal";
$statement = $koneksi->prepare($sql);
$statement->bindValue(':tanggal', $tanggal, PDO::PARAM_STR);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>
    <div class="row justify-content-center mb-3">
        <ul class="nav nav-tabs justify-content-center mb-5">
            <li class="nav-item">
                <a class="nav-link" href="daftar_anak.php">Daftar Anak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="kehadiran.php">Kehadiran</a>
            </li>
        </ul>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Kehadiran</div>
                </div>
                <div class="card-body text-right">
                    <form method="GET" class="form-inline mb-3">
                        <input type="date" name="tanggal" class="form-control mr-2"
                               value="<?= htmlspecialchars($tanggal) ?>">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary ml-2" onclick="cetak()">Cetak</button>
                    </form>
                    <script>
                        function cetak() {
                            var tanggal = document.querySelector('input[type="date"]').value;
                            window.open('../db/queries/CetakKehadiran.php?tanggal=' + tanggal, '_blank');
                        }
                    </script>
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($kehadiran as $key => $value): ?>
                            <?php
                            $sql = "SELECT nama FROM anak WHERE id = :id";
                            $statement = $koneksi->prepare($sql);
                            $statement->bindParam(':id', $value['anak_id']);
                            $statement->execute();
                            $anak = $statement->fetch();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($anak['nama']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal']); ?></td>
                                <td><?= htmlspecialchars($value['jam_masuk']); ?></td>
                                <td><?= htmlspecialchars($value['jam_keluar']); ?></td>
                                <td>
                                    <form method="POST" action="../db/queries/HapusKehadiran.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kehadiran ini?');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger"><i class="las la-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <?php
                    $entries_start = $offset + 1;
                    $entries_end = $offset + count($kehadiran);
                    $total_entries = $total_rows;

                    echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?tanggal=<?= $tanggal ?>&page=1">First</a>
                            </li>
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                           href="?tanggal=<?= $tanggal ?>&page=<?= $page - 1 ?>"><</a>
                            </li>
                            <?php
                            $num_links_to_display = 2;
                            $start = max(1, $page - $num_links_to_display);
                            $end = min($total_pages, $page + $num_links_to_display);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link"
                                                                                              href="?tanggal=<?= $tanggal ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?tanggal=<?= $tanggal ?>&page=<?= $page + 1 ?>">></a>
                            </li>
                            <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                      href="?tanggal=<?= $tanggal ?>&page=<?= $total_pages ?>">Last</a>
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