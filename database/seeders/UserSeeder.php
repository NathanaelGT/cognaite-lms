<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
        ]);

        if ($name = env('DB_SEED_COHORT_NAME')) {
            User::factory()->cohort()->create([
                'name' => $name,
                'email' => env('DB_SEED_COHORT_EMAIL'),
            ]);
        }
    }
}
