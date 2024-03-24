<?php

namespace Database\Seeders;

use App\Models\Dir\DirCargo;
use Illuminate\Database\Seeder;

class DirCargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirCargo::create([
            'name' => 'Доска',
        ]);
        DirCargo::create([
            'name' => 'Брус',
        ]);
        DirCargo::create([
            'name' => 'Поддоны',
        ]);
        DirCargo::create([
            'name' => 'Щепа топливная',
        ]);
        DirCargo::create([
            'name' => 'Щепа арболит',
        ]);
        DirCargo::create([
            'name' => 'Опилки',
        ]);
        DirCargo::create([
            'name' => 'Биомасса',
        ]);
        DirCargo::create([
            'name' => 'Баланс береза',
        ]);
        DirCargo::create([
            'name' => 'Баланс сосна',
        ]);
        DirCargo::create([
            'name' => 'Пиловочник',
        ]);
        DirCargo::create([
            'name' => 'Тонкомер',
        ]);
        DirCargo::create([
            'name' => 'Горбыль',
        ]);
        DirCargo::create([
            'name' => 'Дрова',
        ]);
    }
}
