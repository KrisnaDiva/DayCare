<?php
$title = "Jenis Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10; // Jumlah jenis paket per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM jenis_paket LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$detail_paket = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM jenis_paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs justify-content-center mb-5">
                <li class="nav-item">
                    <a class="nav-link " href="paket.php">Daftar Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="jenis_paket.php">Jenis Paket</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Jenis Paket</div>
                </div>
                <div class="card-body text-right">
                    <a href="tambah_jenis_paket.php" class="btn btn-primary mb-3 mr-3"><i class="las la-plus"></i> Jenis</a>

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($detail_paket as $key => $value): ?>
                            <?php
                            $sql = "SELECT nama FROM paket WHERE id = ?";
                            $statement = $koneksi->prepare($sql);
                            $statement->execute([$value['paket_id']]);
                            $paket = $statement->fetch();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($paket['nama']); ?></td>
                                <td><?= htmlspecialchars($value['periode']); ?></td>
                                <td><?= htmlspecialchars($value['jenis']); ?></td>
                                <td><?= htmlspecialchars($value['harga']); ?></td>
                                <td style="display: inline-block;">
                                    <a href="edit_jenis_paket.php?id=<?= $value['id']; ?>"
                                       style="display: inline-block;" class="btn btn-warning"><i
                                                class="las la-edit"></i></a>

                                    <form method="POST" action="../db/queries/HapusJenisPaket.php"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis paket ini?');">
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
                    // Hitung jumlah entri yang ditampilkan
                    $entries_start = $offset + 1;
                    $entries_end = $offset + count($detail_paket);
                    $total_entries = $total_rows;

                    // Tampilkan teks
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