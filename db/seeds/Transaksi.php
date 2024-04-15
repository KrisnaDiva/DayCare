<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Transaksi extends AbstractSeed
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
        for ($i = 0; $i < 100; $i++) {
            $data = array(
                array(
                    'user_id' => 3,
                    'nama_paket' => 'Paket Harian',
                    'periode_paket' => 'Harian',
                    'jenis_paket' => 'Full Day',
                    'usia_paket' => '1-2 Tahun',
                    'nama_anak' => 'Anak 1',
                    'status' => 'dibayar',
                    'total_bayar' => 100000,
                    'snap_token' => 'token1',
                    'tanggal_transaksi' => '2024-04-12 00:00:00',
                ),
                array(
                    'user_id' => 4,
                    'nama_paket' => 'Paket Mingguan',
                    'periode_paket' => 'Mingguan (Senin - Jumat)',
                    'jenis_paket' => 'Half Day',
                    'usia_paket' => '2-3 Tahun',
                    'nama_anak' => 'Anak 2',
                    'status' => 'dibayar',
                    'total_bayar' => 500000,
                    'snap_token' => 'token2',
                    'tanggal_transaksi' => '2024-04-14 00:00:00',
                )
            );

            $transaksi = $this->table('transaksi');
            $transaksi->insert($data)->save();
        }
    }
}

