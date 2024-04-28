<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Testimoni extends AbstractSeed
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
        $tingkatKepuasan = ['Puas', 'Tidak Puas', 'Biasa Saja'];

        for ($i = 1; $i <= 10; $i++) {
            $data = array(
                array(
                    'tingkat_kepuasan' => $tingkatKepuasan[array_rand($tingkatKepuasan)],
                    'pesan' => 'amet nisl suscipit adipiscing bibendum est ultricies integer quis auctor elit sed vulputate mi sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin libero nunc consequat interdum varius sit',
                    'user_id' => $i,
                )
            );

            $testimoni = $this->table('testimoni');
            $testimoni->insert($data)->save();
        }
    }
}
