<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pengasuh extends AbstractSeed
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
                'jenis_kelamin' => 'Laki-Laki',
                'foto' => '',
                'tanggal_lahir' => '1980-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'S1'
            ),
            array(
                'nama' => 'Riri',
                'email' => 'riri@example.com',
                'nomor_telepon' => '089658444102',
                'jenis_kelamin' => 'Perempuan',
                'foto' => '',
                'tanggal_lahir' => '1985-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'S1'
            ),
            array(
                'nama' => 'Rama',
                'email' => 'rama@example.com',
                'nomor_telepon' => '089658444102',
                'jenis_kelamin' => 'Laki-Laki',
                'foto' => '',
                'tanggal_lahir' => '1985-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'D3'
            ),
            array(
                'nama' => 'Rina',
                'email' => 'Rina@example.com',
                'nomor_telepon' => '089658444102',
                'jenis_kelamin' => 'Perempuan',
                'foto' => '',
                'tanggal_lahir' => '1985-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'SMA'
            ),
            array(
                'nama' => 'Bima',
                'email' => 'Bima@example.com',
                'nomor_telepon' => '089658444102',
                'jenis_kelamin' => 'Laki-Laki',
                'foto' => '',
                'tanggal_lahir' => '1985-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'SMA'
            ),
            array(
                'nama' => 'Diki',
                'email' => 'Diki@example.com',
                'nomor_telepon' => '089658444102',
                'jenis_kelamin' => 'Perempuan',
                'foto' => '',
                'tanggal_lahir' => '1985-01-01',
                'tanggal_bergabung' => '2022-01-01',
                'pendidikan_terakhir' => 'SMA'
            ),
        );

        $pengasuh = $this->table('pengasuh');
        $pengasuh->insert($data)->save();
    }
}