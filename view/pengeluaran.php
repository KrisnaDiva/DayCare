<?php
$title = "Pengeluaran";
ob_start();

$bulanSekarang = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahunSekarang = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanSekarang, $tahunSekarang);
$mingguDalamSebulan = ceil($jumlahHari / 7);

$batasAtas = date('Y');
$batasBawah = 2023; // Anda dapat mengubah ini sesuai kebutuhan Anda
?>
    <div class="row justify-content-center mb-3">
        <select name="bulan" class="form-control col-4" id="bulan" onchange="updateQueryParams()">
            <?php
            $batasBulan = $tahunSekarang == $batasAtas ? date('m') : 12;
            for ($i = 1; $i <= $batasBulan; $i++): ?>
                <option value="<?= $i ?>" <?= $i == $bulanSekarang ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                </option>
            <?php endfor; ?>
        </select>

        <select name="tahun" class="form-control col-4" id="tahun" onchange="updateQueryParams()">
            <?php for ($i = $batasAtas; $i >= $batasBawah; $i--): ?>
                <option value="<?= $i ?>" <?= $i == $tahunSekarang ? 'selected' : '' ?>>
                    <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
        <div class="col-md-10" id="minggu-container">
            <?php
            for ($i = 1; $i <= $mingguDalamSebulan; $i++) {
                $mulai = ($i - 1) * 7 + 1;
                $akhir = $i * 7;

                if ($akhir > $jumlahHari) {
                    $akhir = $jumlahHari;
                }

                $mulaiTanggal = date('j', strtotime("{$tahunSekarang}-{$bulanSekarang}-{$mulai}"));
                $akhirTanggal = date('j F Y', strtotime("{$tahunSekarang}-{$bulanSekarang}-{$akhir}"));
                ?>
                <div class="card p-2">
                    <div class="row">
                        <div class="col-6">
                            <div class="row justify-content-center">
                                <div>
                                    Belum dibuat
                                    <h4><?= "{$mulaiTanggal}-{$akhirTanggal}<br>"; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-center">
                            <div class="row ">
                                <a href="pengeluaran_harian.php?mulai=<?= urlencode($mulaiTanggal) ?>&akhir=<?= urlencode($akhirTanggal) ?>&bulan=<?= urlencode($bulanSekarang) ?>&tahun=<?= urlencode($tahunSekarang) ?>"
                                   class="btn btn-primary">lengkapi laporan harian</a>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        function updateQueryParams() {
            var bulan = document.querySelector('#bulan').value;
            var tahun = document.querySelector('#tahun').value;

            var params = new URLSearchParams(window.location.search);
            params.set('bulan', bulan);
            params.set('tahun', tahun);

            window.location.href = window.location.pathname + '?' + params.toString();
        }
    </script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>