<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Paket extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = array(
            array(
                'nama'    => 'Shine Star',
                'usia_minimal' => 3,
                'foto' => '',
                'usia_maksimal' => 10
            ),
            array(
                'nama'    => 'Tiny Star',
                'foto' => '',
                'usia_minimal' => 0,
                'usia_maksimal' => 2
            )
        );

        $paket = $this->table('paket');
        $paket->insert($data)->save();
    }
}
