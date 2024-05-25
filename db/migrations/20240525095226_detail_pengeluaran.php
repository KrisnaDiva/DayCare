<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DetailPengeluaran extends AbstractMigration
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
        $detailPengeluaran = $this->table('detail_pengeluaran');
        $detailPengeluaran->addColumn('pengeluaran', 'biginteger', ['null' => false])
            ->addColumn('jenis_pengeluaran', 'enum', ['values' => ['Sewa Tempat', 'Listrik', 'Peralatan Bermain', 'Perlengkapan Daycare', 'Makanan dan Minuman', 'Transportasi', 'Air', 'Tukang'], 'null' => false])
            ->addColumn('pengeluaran_id', 'integer', ['null' => false])
            ->create();
    }
}
