<?php
$title = "Beri Penilaian";
ob_start();
session_start();
require_once __DIR__ . "/../db/koneksi.php";
$koneksi = getKoneksi();

$stmt = $koneksi->prepare("SELECT * FROM testimoni WHERE user_id = ?");
$stmt->execute([$_SESSION['id']]);

$data = $stmt->fetch();

?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Beri Penilaian</h5>
                </div>
                <div class="card-body">
                    <form action="../db/queries/BeriPenilaian.php" method="post">
                        <div class="form-group">
                            <label for="tingkat_kepuasan">Tingkat Kepuasan:</label>
                            <select class="form-control" id="tingkat_kepuasan" name="tingkat_kepuasan" required>
                                <option value="">Pilih Tingkat Kepuasan</option>
                                <option value="Puas" <?php echo $data && $data['tingkat_kepuasan'] == 'Puas' ? 'selected' : ''; ?>>
                                    Puas
                                </option>
                                <option value="Biasa Saja" <?php echo $data && $data['tingkat_kepuasan'] == 'Biasa Saja' ? 'selected' : ''; ?>>
                                    Biasa Saja
                                </option>
                                <option value="Tidak Puas" <?php echo $data && $data['tingkat_kepuasan'] == 'Tidak Puas' ? 'selected' : ''; ?>>
                                    Tidak Puas
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan:</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="3"
                                      required><?php echo $data ? $data['pesan'] : ''; ?></textarea>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>