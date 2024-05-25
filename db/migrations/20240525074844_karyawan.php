<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Karyawan extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $pengasuh = $this->table('karyawan');
        $pengasuh->addColumn('nama', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('nomor_telepon', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('posisi', 'enum', ['values' => ['Admin', 'Pengasuh', 'Satpam'], 'null' => false])
            ->addColumn('gaji', 'integer', ['null' => false])
            ->addColumn('jenis_kelamin', 'enum', ['values' => ['Laki-Laki', 'Perempuan'], 'null' => false])
            ->addColumn('pendidikan_terakhir', 'enum', ['values' => ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'], 'null' => false])
            ->addColumn('tanggal_lahir', 'date', ['null' => false])
            ->addColumn('tanggal_bergabung', 'date', ['null' => false])
            ->create();
    }
}
