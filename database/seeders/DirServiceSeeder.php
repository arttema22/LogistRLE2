<?php

namespace Database\Seeders;

use App\Models\DirService;
use App\Models\DirSrevice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DirServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirService::create([
            'title' => 'Погрузка',
            'price' => 500.00,
        ]);
        DirService::create([
            'title' => 'Разгрузка',
            'price' => 500.00,
        ]);
        DirService::create([
            'title' => 'Раскомлевка',
            'price' => 500.00,
        ]);
        DirService::create([
            'title' => 'Сортировка',
            'price' => 500.00,
        ]);
    }
}
