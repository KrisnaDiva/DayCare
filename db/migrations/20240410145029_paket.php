<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Paket extends AbstractMigration
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
        $paket = $this->table('paket');
        $paket->addColumn('nama', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('foto', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('usia_minimal', 'integer', ['null' => false])
            ->addColumn('usia_maksimal', 'integer', ['null' => false])
            ->create();
    }
}
