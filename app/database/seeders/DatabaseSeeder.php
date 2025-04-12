<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\BuildingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Src\Users\Models\User::factory(10)->create([
            'password' => bcrypt('secret'),
        ]);

        BuildingFactory::new()->count(10)->create();
    }
}
