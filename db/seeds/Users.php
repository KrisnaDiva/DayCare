<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
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
                'nama'    => 'John Doe',
                'email'    => 'john.doe@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'jenis_kelamin' => 'Laki-Laki',
                'nomor_telepon' => '089658444101',
                'foto_profil' => null,
                'role' => 'owner',
            ),
            array(
                'nama'    => 'Jane Doe',
                'email'    => 'jane.doe@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'jenis_kelamin' => 'Perempuan',
                'nomor_telepon' => '089658444102',
                'foto_profil' => null,
                'role' => 'admin',
            ),
            array(
                'nama'    => 'Joni Doe',
                'email'    => 'joni.doe@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'jenis_kelamin' => 'Laki-Laki',
                'nomor_telepon' => '089658444103',
                'foto_profil' => null,
                'role' => 'user',
            ),
            array(
                'nama'    => 'Krisna Diva',
                'email'    => 'krisnadiva@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'jenis_kelamin' => 'Laki-Laki',
                'nomor_telepon' => '089658444104',
                'foto_profil' => null,
                'role' => 'user',
            )
        );

        $user = $this->table('users');
        $user->insert($data)->save();
    }
}
