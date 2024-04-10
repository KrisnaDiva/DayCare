<?php
$title = "Pengasuh";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM pengasuh";
$statement = $koneksi->prepare($sql);
$statement->execute();
$pengasuh = $statement->fetchAll();
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Pengasuh</div>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pengasuh as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['nama']); ?></td>
                                <td>
                                    <img src="../db/image/<?= htmlspecialchars($value['foto']); ?>" alt="Foto Profil"
                                         width="50" height="50">
                                </td>
                                <td><?= htmlspecialchars($value['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($value['email']); ?></td>
                                <td><?= htmlspecialchars($value['nomor_telepon']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_lahir']); ?></td>
                                <td><?= htmlspecialchars($value['tanggal_bergabung']); ?></td>
                                <td>
                                    <form method="POST" action="../db/queries/HapusPengasuh.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengasuh ini?');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="edit_pengasuh.php?id=<?= $value['id']; ?>" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="tambah_pengasuh.php" class="btn btn-primary">Tambah Pengasuh</a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>