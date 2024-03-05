<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents; // отключить запуск событий при заливке данных
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MoonshineUserRoleSeeder::class,
            MoonshineUserSeeder::class,

            SetupIntegrationSeeder::class,
        ]);
    }
}
