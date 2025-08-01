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
            'produit_id' => 1,
            'quantite' => 2,
            'prix_ligne' => 30000,
            'commande_id' => 1,

        ]];

        DB::table('ligne_commandes')->insert($ligne);
    }
}

