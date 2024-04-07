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
            ->addColumn('foto', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('tanggal_lahir', 'date', ['null' => false])
            ->addColumn('tanggal_bergabung', 'date', ['null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}