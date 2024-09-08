<?php

namespace Core\Infra\Database\Mysql\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'João da Silva',
            'email' => 'joao.silva@email.com',
            'password' => Hash::make('!Senha123'),
        ]);
    }
}
