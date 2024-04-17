<?php
$title = "Perbaiki Pengeluaran Harian";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = isset($_GET['id']) ? $_GET['id'] : null;
$sql = "SELECT * FROM pengeluaran WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$pengeluaran = $statement->fetch();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/PerbaikiPengeluaranHarian.php" method="POST">
                    <input type="hidden" name="id" value="<?= $pengeluaran['id'] ?>">
                    <div class="card-header">
                        <div class="card-title">Perbaiki Pengeluaran Harian</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal"
                                   readonly value="<?= $pengeluaran['tanggal'] ?>"></div>
                        <div class="form-group">
                            <label for="total_pengeluaran">Total Pengeluaran</label>
                            <input type="number" class="form-control" name="total_pengeluaran"
                                   placeholder="Masukkan Total Pengeluaran" value="<?= $pengeluaran['total_pengeluaran'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"
                                      required><?= $pengeluaran['keterangan'] ?></textarea>
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