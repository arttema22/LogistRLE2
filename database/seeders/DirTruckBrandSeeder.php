<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dir\DirTruckBrand;

class DirTruckBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirTruckBrand::create([
            'name' => 'Mercedes-Benz'
        ]);
        DirTruckBrand::create([
            'name' => 'Volvo'
        ]);
        DirTruckBrand::create([
            'name' => 'Scania'
        ]);
    }
}
