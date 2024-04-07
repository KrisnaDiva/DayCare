<?php
$title = "Ubah Password";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <div class="card">
                <form action="../db/queries/UbahPassword.php" method="POST" >
                    <div class="card-header">
                        <div class="card-title">Ubah Password</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password_lama">Password lama</label>
                            <input type="password" class="form-control" name="password_lama" placeholder="Masukkan password lama" required>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password_baru">Password baru</label>
                            <input type="password" class="form-control" name="password_baru" placeholder="Masukkan password baru" required  minlength="8">
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-warning">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>