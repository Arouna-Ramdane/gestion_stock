<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $commandes=[[
            'dateCommande' => now(),
            'prix_total' => 1230000,
            'user_id' => 1,
            'client_id' => 1
        ]];

        DB::table('commandes')->insert($commandes);
    }
}
