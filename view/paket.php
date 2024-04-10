<?php
$title = "Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$paket = $statement->fetchAll();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
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
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
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
                                <td><?= htmlspecialchars($value['usia_minimal']); ?></td>
                                <td><?= htmlspecialchars($value['usia_maksimal']); ?></td>
                                <td>
                                    <form method="POST" action="../db/queries/HapusPaket.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini? Menghapus paket juga akan menghapus jenis paket yang terkait.');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="tambah_jenis_paket.php?id=<?= $value['id']; ?>" class="btn btn-primary">Tambah
                                        Jenis</a>
                                    <a href="edit_paket.php?id=<?= $value['id']; ?>" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="tambah_paket.php" class="btn btn-primary">Tambah Paket</a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>