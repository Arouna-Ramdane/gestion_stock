<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $produits=[[
            'libelle' => 'frigo',
            'prix' => 230000,
            'quantiteStock' => 10,
        ],[
            'libelle' => 'tele',
            'prix' => 100000,
            'quantiteStock' => 16,
        ],[
            'libelle' => 'Iphone',
            'prix' => 600000,
            'quantiteStock' => 27,
        ],[
            'libelle' => 'mp3',
            'prix' => 10000,
            'quantiteStock' => 22,
        ]];

        DB::table('produits')->insert($produits);
    }
}
