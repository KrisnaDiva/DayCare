<?php
$title = "Edit Pengasuh";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM pengasuh WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$pengasuh = $statement->fetch();

$nama = htmlspecialchars($pengasuh['nama']);
$nomor_telepon = htmlspecialchars($pengasuh['nomor_telepon']);
$email = htmlspecialchars($pengasuh['email']);
$jenis_kelamin = htmlspecialchars($pengasuh['jenis_kelamin']);
$foto = htmlspecialchars($pengasuh['foto']);
$tanggal_lahir = htmlspecialchars($pengasuh['tanggal_lahir']);
$tanggal_bergabung = htmlspecialchars($pengasuh['tanggal_bergabung']);

?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/UbahPengasuh.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="card-header">
                        <div class="card-title">Edit Pengasuh</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="foto">Foto</label> <br>
                            <?php if ($foto): ?>
                                <img id="preview" src="../db/image/<?= $foto ?>" alt="Foto" width="100" height="100">
                            <?php endif; ?>
                            <input id="foto" type="file" class="form-control" name="foto" >
                        </div>
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
    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
    <select class="form-control" name="pendidikan_terakhir" required>
        <option selected value="">Pilih Pendidikan Terakhir</option>
        <option value="SD" <?= $pengasuh['pendidikan_terakhir'] == 'SD' ? 'selected' : ''; ?>>SD</option>
        <option value="SMP" <?= $pengasuh['pendidikan_terakhir'] == 'SMP' ? 'selected' : ''; ?>>SMP</option>
        <option value="SMA" <?= $pengasuh['pendidikan_terakhir'] == 'SMA' ? 'selected' : ''; ?>>SMA</option>
        <option value="D1" <?= $pengasuh['pendidikan_terakhir'] == 'D1' ? 'selected' : ''; ?>>D1</option>
        <option value="D2" <?= $pengasuh['pendidikan_terakhir'] == 'D2' ? 'selected' : ''; ?>>D2</option>
        <option value="D3" <?= $pengasuh['pendidikan_terakhir'] == 'D3' ? 'selected' : ''; ?>>D3</option>
        <option value="D4" <?= $pengasuh['pendidikan_terakhir'] == 'D4' ? 'selected' : ''; ?>>D4</option>
        <option value="S1" <?= $pengasuh['pendidikan_terakhir'] == 'S1' ? 'selected' : ''; ?>>S1</option>
        <option value="S2" <?= $pengasuh['pendidikan_terakhir'] == 'S2' ? 'selected' : ''; ?>>S2</option>
        <option value="S3" <?= $pengasuh['pendidikan_terakhir'] == 'S3' ? 'selected' : ''; ?>>S3</option>
    </select>
</div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $email ?>" placeholder="Masukkan email" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telpon</label>
                            <input type="number" class="form-control" name="nomor_telepon" value="<?= $nomor_telepon ?>" placeholder="Masukkan No telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" value="<?= $tanggal_lahir ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_bergabung">Tanggal Bergabung</label>
                            <input type="date" class="form-control" name="tanggal_bergabung" value="<?= $tanggal_bergabung ?>" required>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>