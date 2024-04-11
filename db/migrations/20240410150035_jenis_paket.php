<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class JenisPaket extends AbstractMigration
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
        $detail_paket = $this->table('jenis_paket');
        $detail_paket->addColumn('periode', 'enum', ['values' => ['Harian', 'Mingguan (Senin - Jumat)', 'Mingguan (Senin - Sabtu)', 'Bulanan (Senin - Jumat)', 'Bulanan (Senin - Sabtu)'], 'null' => false])
            ->addColumn('jenis', 'enum', ['values' => ['Full Day', 'Half Day'], 'null' => false])
            ->addColumn('harga', 'biginteger', ['null' => false])
            ->addColumn('paket_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
