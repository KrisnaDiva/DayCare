<?php
$title = "Jenis Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM jenis_paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$detail_paket = $statement->fetchAll();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <ul class="nav nav-tabs justify-content-center mb-5">
                <li class="nav-item">
                    <a class="nav-link " href="paket.php">Daftar Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="jenis_paket.php" >Jenis Paket</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Jenis Paket</div>
                </div>
                <div class="card-body">
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
                                <td>
                                    <form method="POST" action="../db/queries/HapusJenisPaket.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis paket ini?');">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <a href="edit_jenis_paket.php?id=<?= $value['id']; ?>" class="btn btn-warning">Edit</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="tambah_jenis_paket.php" class="btn btn-primary">Tambah Jenis Paket</a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>