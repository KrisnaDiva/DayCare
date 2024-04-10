<?php
$title = "Edit Anak";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM anak WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$anak = $statement->fetch();

$nama = htmlspecialchars($anak['nama']);
$jenis_kelamin = htmlspecialchars($anak['jenis_kelamin']);
$tanggal_lahir = htmlspecialchars($anak['tanggal_lahir']);

?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/UbahAnak.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="card-header">
                        <div class="card-title">Edit Anak</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= $nama ?>" placeholder="Masukkan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" aria-label="Default select example" name="jenis_kelamin"
                                    required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-Laki" <?= $jenis_kelamin == 'Laki-Laki' ? 'selected' : ''; ?>>
                                    Laki-Laki
                                </option>
                                <option value="Perempuan" <?= $jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" value="<?= $tanggal_lahir ?>" required>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>