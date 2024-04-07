<?php
$title = "Admin";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
session_start();
$koneksi = getKoneksi();

$sql = "SELECT id, nama, nomor_telepon, email, foto_profil, jenis_kelamin FROM users WHERE role = 'admin'";
$statement = $koneksi->prepare($sql);
$statement->execute();
$admins = $statement->fetchAll();
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Admin</div>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($admins as $key => $admin): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($admin['nama']); ?></td>
                                <td><?= htmlspecialchars($admin['jenis_kelamin']); ?></td>
                                <td><?= htmlspecialchars($admin['email']); ?></td>
                                <td><?= htmlspecialchars($admin['nomor_telepon']); ?></td>
                                <td>
                                    <form method="POST" action="../db/queries/HapusAdmin.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                                        <input type="hidden" name="id" value="<?= $admin['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="tambah_admin.php" class="btn btn-primary">Tambah Admin</a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>