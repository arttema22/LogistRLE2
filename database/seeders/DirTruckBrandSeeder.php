<?php

namespace Database\Seeders;

use App\Models\DirTruckBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirTruckBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirTruckBrand::create([
            'name' => 'Другое'
        ]);
        DirTruckBrand::create([
            'name' => 'Mitsubishi'
        ]);
        DirTruckBrand::create([
            'name' => 'Mercedes-Benz'
        ]);
        DirTruckBrand::create([
            'name' => 'SCANIA'
        ]);
        DirTruckBrand::create([
            'name' => 'HYUNDAI'
        ]);
        DirTruckBrand::create([
            'name' => 'BMW'
        ]);
        DirTruckBrand::create([
            'name' => 'VOLVO'
        ]);
    }
}
