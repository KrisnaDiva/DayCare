<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Anak extends AbstractSeed
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
        for ($i = 1; $i <= 10; $i++) {
            $data = array(
                array(
                    'nama' => 'John Doe',
                    'tanggal_lahir' => date('2023-01-01'),
                    'jenis_kelamin' => 'Laki-Laki',
                    'user_id' => $i,
                ),
                array(
                    'nama' => 'Jane Doe',
                    'tanggal_lahir' => date('2022-01-01'),
                    'jenis_kelamin' => 'Perempuan',
                    'user_id' => $i,
                )
            );

            $anak = $this->table('anak');
            $anak->insert($data)->save();
        }
    }
}
