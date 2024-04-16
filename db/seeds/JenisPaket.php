<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class JenisPaket extends AbstractSeed
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
                'periode' => 'Harian',
                'jenis' => 'Half Day',
                'harga' => 100000,
                'paket_id' => 1
            ),
            array(
                'periode' => 'Mingguan (Senin - Jumat)',
                'jenis' => 'Full Day',
                'harga' => 400000,
                'paket_id' => 1
            ),
            array(
                'periode' => 'Mingguan (Senin - Sabtu)',
                'jenis' => 'Half Day',
                'harga' => 500000,
                'paket_id' => 1
            ),
            array(
                'periode' => 'Bulanan (Senin - Jumat)',
                'jenis' => 'Full Day',
                'harga' => 1500000,
                'paket_id' => 1
            ),
            array(
                'periode' => 'Bulanan (Senin - Sabtu)',
                'jenis' => 'Half Day',
                'harga' => 2000000,
                'paket_id' => 1
            ),
            array(
                'periode' => 'Harian',
                'jenis' => 'Full Day',
                'harga' => 50000,
                'paket_id' => 2
            ),
            array(
                'periode' => 'Mingguan (Senin - Jumat)',
                'jenis' => 'Half Day',
                'harga' => 200000,
                'paket_id' => 2
            ),
            array(
                'periode' => 'Mingguan (Senin - Sabtu)',
                'jenis' => 'Full Day',
                'harga' => 250000,
                'paket_id' => 2
            ),
            array(
                'periode' => 'Bulanan (Senin - Jumat)',
                'jenis' => 'Half Day',
                'harga' => 750000,
                'paket_id' => 2
            ),
            array(
                'periode' => 'Bulanan (Senin - Sabtu)',
                'jenis' => 'Full Day',
                'harga' => 1000000,
                'paket_id' => 2
            )
        );

        $jenis_paket = $this->table('jenis_paket');
        $jenis_paket->insert($data)->save();
    }
}