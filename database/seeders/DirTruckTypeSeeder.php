<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dir\DirTruckType;

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
    }
}
