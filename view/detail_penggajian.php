<?php
$title = "Detail Penggajian";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "SELECT * FROM penggajian WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$penggajian = $stmt->fetch();

$sql = "SELECT * FROM detail_penggajian WHERE penggajian_id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$detail_penggajian = $stmt->fetchAll();
?>

    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between px-3">

                        <div class="card-title">Detail Penggajian</div>
                            <div>
                                <a href="../db/queries/CetakPenggajian.php?id=<?= $id ?>"
                                        class="btn btn-secondary ml-2">Cetak
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Periode:</strong> <?= $penggajian['periode'] ?></p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Bayar:</strong> <?= $penggajian['tanggal_bayar'] ?></p>
                                <hr>
                            </div>

                        </div>

                        <?php
                        foreach ($detail_penggajian as $index => $detail):?>
                            <div id="group<?= $index ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nama Karyawan:</strong> <?= $detail['nama_karyawan'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Gaji Pokok:</strong>
                                            Rp<?= number_format($detail['gaji_pokok'], 0, ',', '.') ?></p>
                                        <p><strong>Tunjangan:</strong>
                                            Rp<?= number_format($detail['tunjangan'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                                <hr> <!-- This will create a horizontal line after each employee's details -->
                            </div>
                        <?php endforeach; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Total:</strong> Rp<?= number_format($penggajian['total'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>