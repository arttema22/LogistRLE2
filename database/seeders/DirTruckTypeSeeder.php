<?php

namespace Database\Seeders;

use App\Models\DirTruckType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirTruckTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirTruckType::create([
            'name' => 'Щеповоз'
        ]);
        DirTruckType::create([
            'name' => 'Тент'
        ]);
        DirTruckType::create([
            'name' => 'Лесовоз'
        ]);
        DirTruckType::create([
            'name' => 'Лесовоз-фишка'
        ]);
        DirTruckType::create([
            'name' => 'Mitsubishi FUSSO'
        ]);
    }
}
