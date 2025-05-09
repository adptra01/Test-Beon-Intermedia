<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Resident::factory(10)->create();
        \App\Models\House::factory(10)->create();
        \App\Models\HouseResident::factory(10)->create();
        \App\Models\Payment::factory(10)->create();
        \App\Models\Expense::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'RT',
            'email' => 'admin@testing.com',
        ]);
    }
}
