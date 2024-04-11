<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Transaksi extends AbstractMigration
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
        $transaksi = $this->table('transaksi');
        $transaksi->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('anak_id', 'integer', ['null' => false])
            ->addColumn('jenis_paket_id', 'integer', ['null' => false])
            ->addColumn('status', 'enum', ['values' => ['belum dibayar', 'dibayar', 'dibatalkan'], 'null' => false])
            ->addColumn('total_bayar', 'biginteger', ['null' => false])
            ->addColumn('snap_token', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('tanggal_transaksi', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false]) // add 'null' => false
            ->create();
    }
}
