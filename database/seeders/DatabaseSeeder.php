<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolePermissionSeeder::class,
            PersonneSeeder::class,
            UserSeeder::class,
            ClientSeeder::class,
            ProduitSeeder::class,
            CommandeSeeder::class,
            LigneCommandeSeeder::class,

        ]);

    }
}
