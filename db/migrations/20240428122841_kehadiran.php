<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Kehadiran extends AbstractMigration
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
        $kehadiran = $this->table('kehadiran');
        $kehadiran->addColumn('anak_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false])
            ->addColumn('tanggal', 'date', ['null' => false])
            ->addColumn('jam_masuk', 'time')
            ->addColumn('jam_keluar', 'time')
            ->create();
    }
}
