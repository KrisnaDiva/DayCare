<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Transaksi extends AbstractSeed
{
    public function run(): void
    {
        $startTimestamp = strtotime('April 1');

        for ($i = 0; $i < 10; $i++) {
            $randomTimestamp = rand($startTimestamp, time());
            $randomDate = date('Y-m-d H:i:s', $randomTimestamp);
            $user_id = rand(1, 10);
            $data = array(
                array(
                    'user_id' => $user_id,
                    'nama_paket' => 'Paket Harian',
                    'periode_paket' => 'Harian',
                    'jenis_paket' => 'Full Day',
                    'usia_paket' => '1-2 Tahun',
                    'nama_anak' => 'Anak 1',
                    'status' => 'dibayar',
                    'total_bayar' => 100000,
                    'snap_token' => 'token1',
                    'tanggal_transaksi' => $randomDate,
                ),
                array(
                    'user_id' => $user_id,
                    'nama_paket' => 'Paket Mingguan',
                    'periode_paket' => 'Mingguan (Senin - Jumat)',
                    'jenis_paket' => 'Half Day',
                    'usia_paket' => '2-3 Tahun',
                    'nama_anak' => 'Anak 2',
                    'status' => 'dibatalkan',
                    'total_bayar' => 500000,
                    'snap_token' => 'token2',
                    'tanggal_transaksi' => $randomDate,
                )
            );

            $transaksi = $this->table('transaksi');
            $transaksi->insert($data)->save();
        }
    }
}