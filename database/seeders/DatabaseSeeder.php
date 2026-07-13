<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin user (idempotent: safe to run on every container start)
        User::firstOrCreate(
            ['email' => 'superadmin@cowfarm.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'farm_id' => null,
            ]
        );

        // Seed reference breeds (BreedSeeder already uses firstOrCreate)
        $this->call(BreedSeeder::class);
    }
}
