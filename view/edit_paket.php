<?php
$title = "Ubah Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM paket WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$paket = $statement->fetch();

$nama = htmlspecialchars($paket['nama']);
$foto = htmlspecialchars($paket['foto']);
$usia_minimal = htmlspecialchars($paket['usia_minimal']);
$usia_maksimal = htmlspecialchars($paket['usia_maksimal']);
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/UbahPaket.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="card-header">
                        <div class="card-title">Edit Paket</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="foto">Foto</label> <br>
                            <?php if ($foto): ?>
                                <img id="preview" src="../db/image/<?= $foto ?>" alt="Foto" width="100" height="100">
                            <?php endif; ?>
                            <input id="foto" type="file" class="form-control" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama"
                                   value="<?= $nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_minimal">Usia Minimal</label>
                            <input type="number" class="form-control" name="usia_minimal"
                                   placeholder="Masukkan usia minimal" value="<?= $usia_minimal ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_maksimal">Usia Maksimal</label>
                            <input type="number" class="form-control" name="usia_maksimal"
                                   placeholder="Masukkan maksimal" value="<?= $usia_maksimal ?>" required>
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
        document.getElementById('foto').addEventListener('change', function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>