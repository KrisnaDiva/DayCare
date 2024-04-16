<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Pengeluaran extends AbstractMigration
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
        $pengeluaran = $this->table('pengeluaran');
        $pengeluaran->addColumn('total_pengeluaran', 'biginteger', ['null' => false])
            ->addColumn('keterangan', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('status', 'enum', ['values' => ['ditolak', 'belum diisi', 'diterima'], 'null' => false])
            ->addColumn('tanggal', 'date', ['null' => false])
            ->addColumn('user_id', 'integer', ['null' => false])
            ->create();
    }
}