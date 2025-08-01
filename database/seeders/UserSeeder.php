<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $userss=[[
            'email' => 'ramdanearouna9@gmail.com',
            'password' => Hash::make('1234'),
            'personne_id' => 1,

            
        ]];

        DB::table('users')->insert($userss);
    }
}
