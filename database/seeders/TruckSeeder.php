<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'С 294 ХК 198',
            'brand_id' => 3,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Р 097 ОТ 198',
            'brand_id' => 3,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'B185AX198',
            'brand_id' => 3,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'О 547 НТ 198',
            'brand_id' => 4,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Е 931 ТН 198',
            'brand_id' => 3,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'B101KB198',
            'brand_id' => 4,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'У 548 ОВ 178',
            'brand_id' => 3,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'О 579 РН 198',
            'brand_id' => 3,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'FH16',
            'reg_num' => 'Y396KT47',
            'brand_id' => 7,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'R500',
            'reg_num' => 'В 185 АХ 198',
            'brand_id' => 4,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Р 792 НХ 198',
            'brand_id' => 3,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Х 060 МН 178',
            'brand_id' => 3,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'В 142 СТ 198',
            'brand_id' => 3,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'А 513 ТН 198',
            'brand_id' => 3,
            'type_id' => 1,
        ]);
    }
}
