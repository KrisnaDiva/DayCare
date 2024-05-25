<?php
$title = "Perbaiki Pengeluaran Harian";
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

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form id="pengeluaranForm" action="../db/queries/PerbaikiPengeluaranHarian.php" method="POST">
                    <input type="hidden" name="id" value="<?= $pengeluaran['id'] ?>">
                    <div class="card-header">
                        <div class="card-title">Perbaiki Pengeluaran Harian</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal"
                                   readonly value="<?= $pengeluaran['tanggal'] ?>"></div>

                        <?php foreach ($detail_pengeluaran as $index => $detail): ?>
                            <div class="form-group" id="group<?= $index ?>">
                                <div>
                                    <label for="pengeluaran<?= $index ?>">Pengeluaran</label>
                                    <input type="number" class="form-control" id="pengeluaran<?= $index ?>"
                                           name="pengeluaran<?= $index ?>" placeholder="Masukkan Pengeluaran"
                                           value="<?= $detail['pengeluaran'] ?>" required>
                                </div>
                                <div>
                                    <label for="jenis_pengeluaran<?= $index ?>">Jenis Pengeluaran</label>
                                    <select class="form-control" id="jenis_pengeluaran<?= $index ?>"
                                            name="jenis_pengeluaran<?= $index ?>" required>
                                        <option value="Sewa Tempat" <?= $detail['jenis_pengeluaran'] == 'Sewa Tempat' ? 'selected' : '' ?>>Sewa Tempat</option>
                                        <option value="Listrik" <?= $detail['jenis_pengeluaran'] == 'Listrik' ? 'selected' : '' ?>>Listrik</option>
                                        <option value="Peralatan Bermain" <?= $detail['jenis_pengeluaran'] == 'Peralatan Bermain' ? 'selected' : '' ?>>Peralatan Bermain</option>
                                        <option value="Perlengkapan Daycare" <?= $detail['jenis_pengeluaran'] == 'Perlengkapan Daycare' ? 'selected' : '' ?>>Perlengkapan Daycare</option>
                                        <option value="Makanan dan Minuman" <?= $detail['jenis_pengeluaran'] == 'Makanan dan Minuman' ? 'selected' : '' ?>>Makanan dan Minuman</option>
                                        <option value="Transportasi" <?= $detail['jenis_pengeluaran'] == 'Transportasi' ? 'selected' : '' ?>>Transportasi</option>
                                        <option value="Air" <?= $detail['jenis_pengeluaran'] == 'Air' ? 'selected' : '' ?>>Air</option>
                                        <option value="Tukang" <?= $detail['jenis_pengeluaran'] == 'Tukang' ? 'selected' : '' ?>>Tukang</option>
                                    </select>
                                </div>
                                <button type="button" onclick="hapusGroup(<?= $index ?>)">Hapus</button>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"
                                      required><?= $pengeluaran['keterangan'] ?></textarea>
                        </div>

                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-primary" id="tambahPengeluaran">Tambah Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    var counter = <?= count($detail_pengeluaran) ?>;

    document.getElementById('tambahPengeluaran').addEventListener('click', function () {
        var form = document.getElementById('pengeluaranForm');
        var keteranganFormGroup = document.querySelector('textarea[name="keterangan"]').parentNode;

        var divGroup = document.createElement('div');
        divGroup.className = 'form-group';
        divGroup.id = 'group' + counter;

        var divPengeluaran = document.createElement('div');
        var labelPengeluaran = document.createElement('label');
        labelPengeluaran.innerHTML = 'Pengeluaran';
        var inputPengeluaran = document.createElement('input');
        inputPengeluaran.type = 'number';
        inputPengeluaran.className = 'form-control';
        inputPengeluaran.id = 'pengeluaran' + counter;
        inputPengeluaran.name = 'pengeluaran' + counter;
        inputPengeluaran.placeholder = 'Masukkan Pengeluaran';
        inputPengeluaran.required = true; // Menambahkan atribut required
        divPengeluaran.appendChild(labelPengeluaran);
        divPengeluaran.appendChild(inputPengeluaran);
        divGroup.appendChild(divPengeluaran);

        var divJenisPengeluaran = document.createElement('div');
        var labelJenisPengeluaran = document.createElement('label');
        labelJenisPengeluaran.innerHTML = 'Jenis Pengeluaran';
        var selectJenisPengeluaran = document.createElement('select');
        selectJenisPengeluaran.className = 'form-control';
        selectJenisPengeluaran.id = 'jenis_pengeluaran' + counter;
        selectJenisPengeluaran.name = 'jenis_pengeluaran' + counter;
        selectJenisPengeluaran.required = true; // Menambahkan atribut required

        var options = ['Sewa Tempat', 'Listrik', 'Peralatan Bermain', 'Perlengkapan Daycare', 'Makanan dan Minuman', 'Transportasi', 'Air', 'Tukang'];
        for (var i = 0; i < options.length; i++) {
            var option = document.createElement('option');
            option.value = options[i];
            option.text = options[i];
            selectJenisPengeluaran.appendChild(option);
        }

        divJenisPengeluaran.appendChild(labelJenisPengeluaran);
        divJenisPengeluaran.appendChild(selectJenisPengeluaran);
        divGroup.appendChild(divJenisPengeluaran);

        var buttonHapusGroup = document.createElement('button');
        buttonHapusGroup.innerHTML = 'Hapus';
        buttonHapusGroup.addEventListener('click', function () {
            divGroup.remove();
            counter--;

            for (var i = parseInt(divGroup.id.replace('group', '')); i <= counter; i++) {
                document.getElementById('group' + (i + 1)).id = 'group' + i;
                document.getElementById('pengeluaran' + (i + 1)).id = 'pengeluaran' + i;
                document.getElementById('pengeluaran' + i).name = 'pengeluaran' + i;
                document.getElementById('jenis_pengeluaran' + (i + 1)).id = 'jenis_pengeluaran' + i;
                document.getElementById('jenis_pengeluaran' + i).name = 'jenis_pengeluaran' + i;
            }
        });
        divGroup.appendChild(buttonHapusGroup);

        keteranganFormGroup.parentNode.insertBefore(divGroup, keteranganFormGroup);

        counter++;
    });

    function hapusGroup(index) {
        var group = document.getElementById('group' + index);
        group.remove();
        counter--;

        for (var i = index; i <= counter; i++) {
            document.getElementById('group' + (i + 1)).id = 'group' + i;
            document.getElementById('pengeluaran' + (i + 1)).id = 'pengeluaran' + i;
            document.getElementById('pengeluaran' + i).name = 'pengeluaran' + i;
            document.getElementById('jenis_pengeluaran' + (i + 1)).id = 'jenis_pengeluaran' + i;
            document.getElementById('jenis_pengeluaran' + i).name = 'jenis_pengeluaran' + i;
        }
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>