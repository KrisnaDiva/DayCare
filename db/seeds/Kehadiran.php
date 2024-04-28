<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Kehadiran extends AbstractSeed
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
                'anak_id' => 1,
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '16:00:00',
            ),
            array(
                'anak_id' => 2,
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => '08:30:00',
                'jam_keluar' => '16:30:00',
            )
        );
        $kehadiran = $this->table('kehadiran');
        $kehadiran->insert($data)->save();
    }
}
