<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'ramdanearouna9@gmail.com',
            'password' => Hash::make('1234'),
            'personne_id' => 1,
            'profile' => null,
        ]);

        $user->assignRole('admin');
    }
}
