<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'status' => 'Active',
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@armayurveda.test'],
            [
                'name' => 'Super Admin',
                'password' => 'admin12345',
                'status' => 'Active',
            ]
        );
    }
}
