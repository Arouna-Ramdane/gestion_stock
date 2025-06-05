<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('produits')->delete();
        DB::table('commandes')->delete();
        DB::table('ligne_commandes')->delete();
        $userss=[[
            'first_name' => 'AROUNA',
            'name' => 'Ramdane',
            'contact' => '91627160',
            'email' => 'ramdanearouna9@gmail.com',
            'adresse' => 'Koulunde',
            'role' => 'gerant',
            'password' => '12345678',
        ],[
            'first_name' => 'YERIMA',
            'name' => 'Mansour',
            'contact' => '70340987',
            'email' => 'manslunick@gmail.com',
            'adresse' => 'kpangalam',
            'role' => 'employe',
            'password' => '12345678',
        ]];

        DB::table('users')->insert($userss);
    }
}
