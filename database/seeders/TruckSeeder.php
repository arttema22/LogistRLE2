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
            'reg_num' => 'C 294 XK 198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'P 097 OT 198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'B 185 AX 198',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'O 547 HT 198',
            'brand_id' => 3,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'E 931 TH 198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'G440',
            'reg_num' => 'B 101 KB 198',
            'brand_id' => 3,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'Y 548 OB 178',
            'brand_id' => 1,
            'type_id' => 3,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'O 579 PH 198',
            'brand_id' => 1,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'FH16',
            'reg_num' => 'Y 396 KT 47',
            'brand_id' => 2,
            'type_id' => 4,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'P 792 HX 198',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'X 060 MH 178',
            'brand_id' => 1,
            'type_id' => 2,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'B 142 CT 198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);

        Truck::create([
            'name' => 'Actros',
            'reg_num' => 'A 513 TH 198',
            'brand_id' => 1,
            'type_id' => 1,
        ]);
    }
}
