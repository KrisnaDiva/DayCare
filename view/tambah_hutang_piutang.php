<?php
$title = "Tambah Hutang Piutang";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahHutangPiutang.php" method="POST">
                    <div class="card-header">
                        <div class="card-title">Tambah Hutang Piutang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                                   value="<?php echo date('Y-m-d'); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="">Pilih jenis</option>
                                <option value="Hutang">Hutang</option>
                                <option value="Piutang">Piutang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="number" class="form-control" id="total" name="total" required>
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