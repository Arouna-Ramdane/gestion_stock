<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LigneCommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $ligne=[[
            'prix_ligne' => 30000,
            'commande_id' => 1,
            'produit_id' => 1,
        ],[
            'prix_ligne' => 1200000,
            'commande_id' => 1,
            'produit_id' => 2,
        ]];

        DB::table('ligne_commandes')->insert($ligne);
    }
}

