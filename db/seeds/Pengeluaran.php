<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pengeluaran extends AbstractSeed
{
    public function run(): void
    {
        $data = [];
        $dataDetail = [];
        $startTimestamp = strtotime('April 1');

        $numDays = (time() - $startTimestamp) / (24 * 60 * 60);

        $dates = [];
        for ($i = $startTimestamp; $i <= time(); $i += 24 * 60 * 60) {
            $dates[] = date('Y-m-d', $i);
        }

        shuffle($dates);

        for ($i = 0; $i < $numDays; $i++) {
            $tanggal = array_pop($dates);
            $total_pengeluaran = ($i + 1) * 10000;
            $keterangan = "Pembelian Bahan Baku tanggal $tanggal";
            $data[] = [
                'total_pengeluaran' => $total_pengeluaran,
                'keterangan' => $keterangan,
                'status' => 'pending',
                'tanggal' => $tanggal,
                'user_id' => 12,
            ];

            $dataDetail[] = [
                'pengeluaran' => $total_pengeluaran ,
                'jenis_pengeluaran' => 'Bahan Baku',
                'pengeluaran_id' => $i + 1,
            ];
        }

        $pengeluaran = $this->table('pengeluaran');
        $pengeluaran->insert($data)->save();
        $detailPengeluaran = $this->table('detail_pengeluaran');
        $detailPengeluaran->insert($dataDetail)->save();
    }
}