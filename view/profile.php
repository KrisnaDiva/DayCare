<?php
$title = "Profil";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
session_start();
$koneksi = getKoneksi();

$sql = "SELECT nama, jenis_kelamin, nomor_telepon, email, foto_profil, alamat FROM users WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['id']]);
$user = $statement->fetch();

$nama = htmlspecialchars($user['nama']);
$nomor_telepon = htmlspecialchars($user['nomor_telepon']);
$email = htmlspecialchars($user['email']);
$jenis_kelamin = htmlspecialchars($user['jenis_kelamin']);
$foto_profil = htmlspecialchars($user['foto_profil']);
$alamat = htmlspecialchars($user['alamat']);
?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/UbahProfil.php" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                        <div class="card-title">Informasi Profil</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="foto_profil">Profile Image:</label>
                            <br>
                            <?php if ($foto_profil): ?>
                                <img id="preview" src="../db/image/<?= $foto_profil ?>" alt="Foto" width="100"
                                     height="100">
                            <?php else: ?>
                                <img id="preview" style="display: none;" alt="Foto" width="100" height="100">
                            <?php endif; ?>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= $nama; ?>" required>
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
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telpon</label>
                            <input type="number" class="form-control" name="nomor_telepon"
                                   value="<?= $nomor_telepon; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" required><?= $alamat ?></textarea>
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
        document.getElementById('foto_profil').addEventListener('change', function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>