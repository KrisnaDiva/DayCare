<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pengeluaran extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            $tanggal = date('Y-m-d', strtotime("2024-04-$i"));
            $total_pengeluaran = $i * 10000; // contoh perhitungan total pengeluaran
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