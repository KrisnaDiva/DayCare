<?php
$title = "Tambah Paket";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahPaket.php" method="POST">
                    <div class="card-header">
                        <div class="card-title">Tambah Paket</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_minimal">Usia Minimal</label>
                            <input type="number" class="form-control" name="usia_minimal" placeholder="Masukkan usia minimal" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_maksimal">Usia Maksimal</label>
                            <input type="number" class="form-control" name="usia_maksimal" placeholder="Masukkan maksimal" required>
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