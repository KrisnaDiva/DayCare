<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pengeluaran extends AbstractSeed
{
    public function run(): void
    {
        $data = [];
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
                'user_id' => 102,
            ];
        }

        $pengeluaran = $this->table('pengeluaran');
        $pengeluaran->insert($data)->save();
    }
}