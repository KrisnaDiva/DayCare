<?php
$title = "Penggajian";
ob_start();
require_once __DIR__ . '/../db/koneksi.php';
$koneksi = getKoneksi();
//$sql = "SELECT * FROM paket";
//$statement = $koneksi->prepare($sql);
//$statement->execute();
//$paket = $statement->fetchAll();

$tahunSekarang = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$bulanSekarang = date('m');

$batasAtas = date('Y');
$batasBawah = 2023;

?>
    <div class="row justify-content-center mb-3">
        <select name="tahun" class="form-control col-4" id="tahun" onchange="updateQueryParams()">
            <?php for ($i = $batasAtas; $i >= $batasBawah; $i--): ?>
                <option value="<?= $i ?>" <?= $i == $tahunSekarang ? 'selected' : '' ?>>
                    <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="row justify-content-center mb-3">
        <?php
        for ($i = 1; $i <= 12; $i++):
            $periode = $tahunSekarang . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $query = $koneksi->prepare("SELECT * FROM penggajian WHERE periode = ?");
            $query->execute([$periode]);
            $isPaid = $query->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                            <?php if ($isPaid): ?>
                                <span>(Sudah Dibayar)</span>
                            <?php endif; ?>
                        </h5>
                        <?php if ($isPaid): ?>
                        <a href="detail_penggajian.php?id=<?= $isPaid['id'] ?>" class="btn btn-secondary" id="detail-<?= $i ?>">Lihat Detail</a>
                        <?php else: ?>
                        <?php if($tahunSekarang == $batasAtas && $i > $bulanSekarang): ?>
                            <button class="btn btn-primary" id="bayar-<?= $i ?>" disabled> Bayar</button>

                        <?php else: ?>
                        <a href="bayar_gaji.php?periode=<?= $tahunSekarang . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) ?>" class="btn btn-primary" id="bayar-<?= $i ?>">Bayar</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endfor; ?>

    </div>

    <script>
        function updateQueryParams() {
            var tahun = document.querySelector('#tahun').value;

            var params = new URLSearchParams(window.location.search);
            params.set('tahun', tahun);

            window.location.href = window.location.pathname + '?' + params.toString();
        }
    </script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>