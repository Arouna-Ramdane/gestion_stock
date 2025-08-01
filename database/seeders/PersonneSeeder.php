<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class PersonneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personnes')->delete();
        DB::table('users')->delete();
        DB::table('produits')->delete();
        DB::table('commandes')->delete();
        DB::table('ligne_commandes')->delete();

        $faker = Faker::create();

        $personnes = [];

        for ($i = 0; $i < 500; $i++) {
            $personnes[] = [
                'first_name' => $faker->firstName,
                'name'       => $faker->lastName,
                'contact'    => $faker->numerify('########'), // 8 chiffres
                'adresse'    => $faker->city,
            ];
        }

        DB::table('personnes')->insert($personnes);
    }
}
