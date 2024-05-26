<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class HutangPiutang extends AbstractSeed
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
                'total' => 1000000,
                'jenis' => 'Hutang',
                'status' => 'Belum Lunas',
                'tanggal_pinjam' => '2024-05-25',
                'tanggal_dibayar' => '2024-05-25',
                'keterangan' => 'Hutang ke teman'
            ],
            [
                'total' => 2000000,
                'jenis' => 'Piutang',
                'status' => 'Lunas',
                'tanggal_pinjam' => '2024-05-25',
                'tanggal_dibayar' => '2024-05-25',
                'keterangan' => 'Piutang dari teman'
            ], [
                'total' => 1000000,
                'jenis' => 'Hutang',
                'status' => 'Lunas',
                'tanggal_pinjam' => '2024-05-25',
                'tanggal_dibayar' => '2024-05-25',
                'keterangan' => 'Hutang ke toko'
            ],
            [
                'total' => 2000000,
                'jenis' => 'Piutang',
                'status' => 'Belum Lunas',
                'tanggal_pinjam' => '2024-05-25',
                'tanggal_dibayar' => '2024-05-25',
                'keterangan' => 'Piutang dari toko'
            ],
            [
                'total' => 2000000,
                'jenis' => 'Piutang',
                'status' => 'Belum Lunas',
                'tanggal_pinjam' => '2024-05-25',
                'tanggal_dibayar' => '2024-05-25',
                'keterangan' => 'Piutang dari toko'
            ],
        ];

        $posts = $this->table('hutang_piutang');
        $posts->insert($data)
            ->save();
    }
}
