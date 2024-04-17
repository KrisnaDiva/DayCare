<?php
$title = "Tambah Pengeluaran Harian";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahPengeluaranHarian.php" method="POST">
                    <div class="card-header">
                        <div class="card-title">Tambah Pengeluaran Harian</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal"
                                   readonly value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>"></div>
                        <div class="form-group">
                            <label for="total_pengeluaran">Total Pengeluaran</label>
                            <input type="number" class="form-control" name="total_pengeluaran"
                                   placeholder="Masukkan Total Pengeluaran" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"
                                      required></textarea>
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