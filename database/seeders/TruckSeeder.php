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
            'reg_num' => 'C294XK198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'P097OT198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'B185AX198',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'O547HT198',
            'brand_id' => 3,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'E931TH198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'B101KB198',
            'brand_id' => 3,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Y548OB178',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'O579PH198',
            'brand_id' => 1,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'FH16',
            'reg_num' => 'Y396KT47',
            'brand_id' => 2,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'P792HX198',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'X060MH178',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'B142CT198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'A513TH198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);
    }
}
