<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [];

        for ($i=2; $i <501 ; $i++) {
            $clients[] = [
                'personne_id' => $i,
            ];
        }

        DB::table('clients')->insert($clients);
    }
}
