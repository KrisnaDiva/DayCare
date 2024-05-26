<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Penggajian extends AbstractSeed
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
                'periode' => '2024-05',
                'tanggal_bayar' => date('2024-05-25'),
                'total' => 9000000,
            ],
        ];

        $table = $this->table('penggajian');
        $table->insert($data)
            ->save();
    }
}
