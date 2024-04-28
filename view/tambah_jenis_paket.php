<?php
$title = "Tambah Jenis Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$paket = $statement->fetchAll();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahJenisPaket.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="card-header">
                        <div class="card-title">Tambah Jenis Paket</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="paket_id">Paket</label>
                            <select class="form-control" aria-label="Default select example" name="paket_id"
                                    required>
                                <option value="">Pilih periode</option>
                                <?php foreach ($paket as $key => $value): ?>
                                    <option value="<?= $value['id'] ?>" <?= $value['id'] == $id ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <select class="form-control" aria-label="Default select example" name="periode"
                                    required>
                                <option selected value="">Pilih periode</option>
                                <option value="Harian">Harian</option>
                                <option value="Mingguan (Senin - Jumat)">Mingguan (Senin - Jumat)</option>
                                <option value="Mingguan (Senin - Sabtu)">Mingguan (Senin - Sabtu)</option>
                                <option value="Bulanan (Senin - Jumat)">Bulanan (Senin - Jumat)</option>
                                <option value="Bulanan (Senin - Sabtu)">Bulanan (Senin - Sabtu)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" aria-label="Default select example" name="jenis"
                                    required>
                                <option selected value="">Pilih periode</option>
                                <option value="Full Day">Full Day</option>
                                <option value="Half Day">Half Day</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" placeholder="Masukkan Harga"
                                   required>
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