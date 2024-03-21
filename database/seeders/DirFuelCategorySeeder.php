<?php

namespace Database\Seeders;

use App\Models\DirFuelCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirFuelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirFuelCategory::create([
            'name' => 'Не определено',
        ]);
        DirFuelCategory::create([
            'name' => 'Дизель',
        ]);
        DirFuelCategory::create([
            'name' => 'Бензин',
        ]);
    }
}
