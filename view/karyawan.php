<?php
$title = "Karyawan";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM karyawan LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$karyawan = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM karyawan";
$statement = $koneksi->prepare($sql);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Karyawan</div>
                </div>
                <div class="card-body text-right">
                    <a href="tambah_karyawan.php" class="btn btn-primary mb-3 mr-4"><i class="las la-plus"></i> Karyawan</a>

                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Gaji</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Bergabung</th>
                            <th>Pendidikan Terakhir</th> <!-- Tambahkan ini -->
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($karyawan as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['nama']); ?></td>
                                <td><?= htmlspecialchars($value['posisi']); ?></td>
                                <td><?= htmlspecialchars($value['gaji']); ?></td>
                                <td><?= htmlspecialchars($value['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($value['email']); ?></td>
                                <td><?= htmlspecialchars($value['nomor_telepon']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_lahir']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_bergabung']); ?></td>
                                <td><?= htmlspecialchars($value['pendidikan_terakhir']); ?></td> <!-- Tambahkan ini -->
                                <td style="display: inline-block;">
                                    <a href="edit_karyawan.php?id=<?= $value['id']; ?>" class="btn btn-warning"
                                       style="display: inline-block;"><i class="las la-edit"></i></a>
                                    <form method="POST" action="../db/queries/HapusKaryawan.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');"
                                          style="display: inline-block;">
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
                    $entries_end = $offset + count($karyawan);
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
                            $num_links_to_display = 2;
                            $start = max(1, $page - $num_links_to_display);
                            $end = min($total_pages, $page + $num_links_to_display);
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