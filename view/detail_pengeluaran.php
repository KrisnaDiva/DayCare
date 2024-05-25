<?php
$title = "Detail Pengeluaran";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
$id = isset($_GET['id']) ? $_GET['id'] : null;
$sql = "SELECT * FROM pengeluaran WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$pengeluaran = $statement->fetch();

// Mengambil detail pengeluaran
$sql = "SELECT * FROM detail_pengeluaran WHERE pengeluaran_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$detail_pengeluaran = $statement->fetchAll();
?>

<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail Pengeluaran Harian</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> <?= $pengeluaran['tanggal'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <?= $pengeluaran['status'] ?></p>
                        </div>
                    </div>

                    <?php
                    $total = 0;
                    foreach ($detail_pengeluaran as $index => $detail):
                        $total += $detail['pengeluaran'];
                    ?>
                        <div id="group<?= $index ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Pengeluaran:</strong> Rp<?= number_format($detail['pengeluaran'], 0, ',', '.') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Jenis Pengeluaran:</strong> <?= $detail['jenis_pengeluaran'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Total Pengeluaran:</strong> Rp<?= number_format($total, 0, ',', '.') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Keterangan:</strong> <?= $pengeluaran['keterangan'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>