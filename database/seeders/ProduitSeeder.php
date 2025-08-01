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
            'libelle' => 'frigo-renz',
            'prix' => 230000,
            'quantiteStock' => 10,
            'image' => "imageProduit/frig-renz.jpeg",
        ]];

        DB::table('produits')->insert($produits);
    }
}
