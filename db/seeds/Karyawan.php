<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Karyawan extends AbstractSeed
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
                'nama' => 'Wisnu',
                'email' => 'wisnu@example.com',
                'nomor_telepon' => '089658444101',
                'gaji' => 5000000,
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '1980-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'S1',
                'posisi' => 'Pengasuh'
            ),
            array(
                'nama' => 'Ucok',
                'email' => 'ucok@example.com',
                'nomor_telepon' => '089658444101',
                'jenis_kelamin' => 'Laki-Laki',
                'gaji' => 4000000,
                'tanggal_lahir' => '1980-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'S1',
                'posisi' => 'Satpam'
            )
        );
        $karyawan = $this->table('karyawan');
        $karyawan->insert($data)->save();
    }
}
