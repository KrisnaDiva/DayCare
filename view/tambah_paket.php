<?php
$title = "Tambah Paket";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahPaket.php" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                        <div class="card-title">Tambah Paket</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="foto">Foto</label> <br>
                            <img id="preview" alt="Foto " width="100" height="100" style="display: none">
                            <input id="foto" type="file" class="form-control" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_minimal">Usia Minimal</label>
                            <input type="number" class="form-control" name="usia_minimal"
                                   placeholder="Masukkan usia minimal" required>
                        </div>
                        <div class="form-group">
                            <label for="usia_maksimal">Usia Maksimal</label>
                            <input type="number" class="form-control" name="usia_maksimal"
                                   placeholder="Masukkan maksimal" required>
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
            document.getElementById('preview').style.display = "block";
            reader.readAsDataURL(this.files[0]);
        });
    </script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>