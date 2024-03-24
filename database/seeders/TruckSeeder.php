<?php

namespace Database\Seeders;

use App\Models\Sys\Truck;
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
            'reg_num_ru' => 'С 294 ХК 198',
            'reg_num_en' => 'C294XK198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Р 097 ОТ 198',
            'reg_num_en' => 'P097OT198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 185 АХ 198',
            'reg_num_en' => 'B185AX198',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num_ru' => 'О 547 НТ 198',
            'reg_num_en' => 'O547HT198',
            'brand_id' => 3,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Е 931 ТН 198',
            'reg_num_en' => 'E931TH198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num_ru' => 'В 101 КВ 198',
            'reg_num_en' => 'B101KB198',
            'brand_id' => 3,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'У 548 ОВ 178',
            'reg_num_en' => 'Y548OB178',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'О 579 РН 198',
            'reg_num_en' => 'O579PH198',
            'brand_id' => 1,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'FH16',
            'reg_num_ru' => 'У 396 КТ 47',
            'reg_num_en' => 'Y396KT47',
            'brand_id' => 2,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Р 792 НХ 198',
            'reg_num_en' => 'P792HX198',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'Х 060 МН 178',
            'reg_num_en' => 'X060MH178',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 142 СТ 198',
            'reg_num_en' => 'B142CT198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'А 513 ТН 198',
            'reg_num_en' => 'A513TH198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num_ru' => 'В 280 ХВ 178',
            'reg_num_en' => 'B280XB178',
            'brand_id' => 1,
            'type_id' => 3,
        ]);
    }
}
