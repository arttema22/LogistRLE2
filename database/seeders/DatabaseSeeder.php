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
            DirTruckBrandSeeder::class,
            DirTruckTypeSeeder::class,
            DirServiceSeeder::class,
            DirCargoSeeder::class,
            DirFuelCategorySeeder::class,

            MoonshineUserRoleSeeder::class,
            MoonshineUserSeeder::class,

            TruckSeeder::class,
            TruckUserSeeder::class,

            SetupIntegrationSeeder::class,
        ]);
    }
}
