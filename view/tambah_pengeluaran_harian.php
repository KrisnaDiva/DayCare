<?php
$title = "Tambah Pengeluaran Harian";
ob_start();
?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <form action="../db/queries/TambahPengeluaranHarian.php" method="POST" id="pengeluaranForm">
                    <div class="card-header">
                        <div class="card-title">Tambah Pengeluaran Harian</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal"
                                   readonly value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>"></div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"
                                      required></textarea>
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
    var counter = 1;

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
</script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>