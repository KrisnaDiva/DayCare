<?php
$title = "Bayar Gaji";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$query = $koneksi->prepare("SELECT * FROM karyawan");
$query->execute();
$karyawan = $query->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
            <div class="card">
                <form action="../db/queries/BayarGaji.php?periode=<?= $_GET['periode'] ?>" method="post">
                    <div class="card-header">
                        <div class="card-title">Bayar Gaji</div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nama Karyawan</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($karyawan as $k): ?>
                                <tr>
                                    <td><input type="text" class="form-control" id="nama_karyawan<?= $k['id'] ?>"
                                               name="nama_karyawan<?= $k['id'] ?>" value="<?= $k['nama'] ?>" readonly>
                                    </td>
                                    <td><input type="number" class="form-control" id="gaji_pokok<?= $k['id'] ?>"
                                               name="gaji_pokok<?= $k['id'] ?>" value="<?= $k['gaji'] ?>" required></td>
                                    <td><input type="number" class="form-control" id="tunjangan<?= $k['id'] ?>"
                                               name="tunjangan<?= $k['id'] ?>"></td>
                                    <input type="hidden" name="id[]" value="<?= $k['id'] ?>">
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>