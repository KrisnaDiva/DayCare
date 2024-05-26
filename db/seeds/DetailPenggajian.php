<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class DetailPenggajian extends AbstractSeed
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
        $data = [
            [
                'penggajian_id' => 1,
                'nama_karyawan' => 'Wisnu',
                'gaji_pokok' => 5000000,
                'tunjangan' => 0,
            ],
            [
                'penggajian_id' => 1,
                'nama_karyawan' => 'Ucok',
                'gaji_pokok' => 4000000,
                'tunjangan' => 0,
            ]
        ];

        $table = $this->table('detail_penggajian');
        $table->insert($data)
            ->save();
    }
}
