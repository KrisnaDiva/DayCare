<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DetailPenggajian extends AbstractMigration
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
        $table = $this->table('detail_penggajian');
        $table->addColumn('nama_karyawan', 'string')
            ->addColumn('gaji_pokok', 'integer')
            ->addColumn('tunjangan', 'integer')
            ->addColumn('penggajian_id', 'integer')
            ->create();
    }
}
