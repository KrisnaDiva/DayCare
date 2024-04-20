<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pengeluaran extends AbstractSeed
{
    public function run(): void
    {
        $data = [];
        // Get timestamp for April 1st of this year
        $startTimestamp = strtotime('April 1');

        // Calculate the number of days from April 1st to now
        $numDays = (time() - $startTimestamp) / (24 * 60 * 60);

        // Generate an array of all dates from April 1st to now
        $dates = [];
        for ($i = $startTimestamp; $i <= time(); $i += 24 * 60 * 60) {
            $dates[] = date('Y-m-d', $i);
        }

        // Shuffle the array to get random dates
        shuffle($dates);

        for ($i = 0; $i < $numDays; $i++) {
            // Take one date from the array for each entry
            $tanggal = array_pop($dates);
            $total_pengeluaran = ($i + 1) * 10000; // contoh perhitungan total pengeluaran
            $keterangan = "Pembelian Bahan Baku tanggal $tanggal"; // contoh keterangan
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