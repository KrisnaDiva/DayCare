<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Anak extends AbstractMigration
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
        $anak = $this->table('anak');
        $anak->addColumn('nama', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('tanggal_lahir', 'date', ['null' => false])
            ->addColumn('jenis_kelamin', 'enum', ['values' => ['Laki-Laki', 'Perempuan'], 'null' => false])
            ->addColumn('langganan', 'timestamp', ['default' => null])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('is_deleted', 'boolean', ['default' => 0])
            ->create();
    }
}
