<?php
$title = "Edit Jenis Paket";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM jenis_paket WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$jenis_paket = $statement->fetch();

$sql = "SELECT * FROM paket";
$statement = $koneksi->prepare($sql);
$statement->execute();
$paket = $statement->fetchAll();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/UbahJenisPaket.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="card-header">
                        <div class="card-title">Edit Jenis Paket</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="paket_id">Paket</label>
                            <select class="form-control" aria-label="Default select example" name="paket_id"
                                    required>
                                <option value="">Pilih periode</option>
                                <?php foreach ($paket as $key => $value): ?>
                                    <option value="<?= $value['id'] ?>" <?= $value['id'] == $jenis_paket['paket_id'] ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <select class="form-control" aria-label="Default select example" name="periode" required>
                                <option value="">Pilih periode</option>
                                <option value="Harian" <?= $jenis_paket['periode'] == 'Harian' ? 'selected' : '' ?>>
                                    Harian
                                </option>
                                <option value="Mingguan (Senin - Jumat)" <?= $jenis_paket['periode'] == 'Mingguan (Senin - Jumat)' ? 'selected' : '' ?>>
                                    Mingguan (Senin - Jumat)
                                </option>
                                <option value="Mingguan (Senin - Sabtu)" <?= $jenis_paket['periode'] == 'Mingguan (Senin - Sabtu)' ? 'selected' : '' ?>>
                                    Mingguan (Senin - Sabtu)
                                </option>
                                <option value="Bulanan (Senin - Jumat)" <?= $jenis_paket['periode'] == 'Bulanan (Senin - Jumat)' ? 'selected' : '' ?>>
                                    Bulanan (Senin - Jumat)
                                </option>
                                <option value="Bulanan (Senin - Sabtu)" <?= $jenis_paket['periode'] == 'Bulanan (Senin - Sabtu)' ? 'selected' : '' ?>>
                                    Bulanan (Senin - Sabtu)
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" aria-label="Default select example" name="jenis" required>
                                <option value="">Pilih jenis</option>
                                <option value="Full Day" <?= $jenis_paket['jenis'] == 'Full Day' ? 'selected' : '' ?>>
                                    Full Day
                                </option>
                                <option value="Half Day" <?= $jenis_paket['jenis'] == 'Half Day' ? 'selected' : '' ?>>
                                    Half Day
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" name="harga" value="<?= $jenis_paket['harga'] ?>"
                                   placeholder="Masukkan Harga" required>
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