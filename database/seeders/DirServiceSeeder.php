<?php

namespace Database\Seeders;

use App\Models\Dir\DirService;
use Illuminate\Database\Seeder;

class DirServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirService::create([
            'name' => 'Погрузка',
            'price' => 500.00,
        ]);
        DirService::create([
            'name' => 'Разгрузка',
            'price' => 500.00,
        ]);
        DirService::create([
            'name' => 'Раскомлевка',
            'price' => 500.00,
        ]);
        DirService::create([
            'name' => 'Сортировка',
            'price' => 500.00,
        ]);
    }
}
