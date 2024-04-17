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
        $data = array(
            array(
                'total_pengeluaran' => 100000,
                'keterangan' => 'Pembelian Bahan Baku',
                'status' => 'diterima',
                'tanggal' => '2024-04-16',
                'user_id' => '',
            ), array(
                'total_pengeluaran' => 500000,
                'keterangan' => 'Pembelian Bahan Baku',
                'status' => 'ditolak',
                'tanggal' => '2024-04-15',
                'user_id' => '',
            ),
            array(
                'total_pengeluaran' => 500000,
                'keterangan' => 'Pembelian Bahan Baku',
                'status' => 'pending',
                'tanggal' => '2024-04-14',
                'user_id' => '',
            )
        );

        $pengeluaran = $this->table('pengeluaran');
        $pengeluaran->insert($data)->save();
    }
}