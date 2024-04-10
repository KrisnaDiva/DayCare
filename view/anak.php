<?php
$title = "Anak";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
session_start();
$koneksi = getKoneksi();

$sql = "SELECT * FROM anak WHERE user_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id']]);
$anak = $statement->fetchAll();
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Anak</div>
                </div>
                <div class="card-body">
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
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['nama']); ?></td>
                                <td><?= htmlspecialchars($value['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_lahir']); ?></td>
                                <td>
                                    <form method="POST" action="../db/queries/HapusAnak.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus anak ini?');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="edit_anak.php?id=<?= $value['id']; ?>" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="tambah_anak.php" class="btn btn-primary">Tambah Anak</a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>