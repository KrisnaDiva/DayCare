<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Pengasuh extends AbstractMigration
{
    public function change(): void
    {
        $pengasuh = $this->table('pengasuh');
        $pengasuh->addColumn('nama', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('nomor_telepon', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('jenis_kelamin', 'enum', ['values' => ['Laki-Laki', 'Perempuan'], 'null' => false])
            ->addColumn('pendidikan_terakhir', 'enum', ['values' => ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'], 'null' => false])
            ->addColumn('foto', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('tanggal_lahir', 'date', ['null' => false])
            ->addColumn('tanggal_bergabung', 'date', ['null' => false])
            ->create();
    }
}