<?php
$title = "Tambah Pengasuh";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahPengasuh.php" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                        <div class="card-title">Tambah Pengasuh</div>
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
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" aria-label="Default select example" name="jenis_kelamin"
                                    required>
                                <option selected value="">Pilih jenis kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
    <select class="form-control" name="pendidikan_terakhir" required>
        <option selected value="">Pilih Pendidikan Terakhir</option>
        <option value="SD">SD</option>
        <option value="SMP">SMP</option>
        <option value="SMA">SMA</option>
        <option value="D1">D1</option>
        <option value="D2">D2</option>
        <option value="D3">D3</option>
        <option value="D4">D4</option>
        <option value="S1">S1</option>
        <option value="S2">S2</option>
        <option value="S3">S3</option>
    </select>
</div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telpon</label>
                            <input type="number" class="form-control" name="nomor_telepon"
                                   placeholder="Masukkan No telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_bergabung">Tanggal Bergabung</label>
                            <input type="date" class="form-control" name="tanggal_bergabung" required>
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