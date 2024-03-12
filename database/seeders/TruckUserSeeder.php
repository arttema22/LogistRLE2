<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TruckUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('truck_user')->insert([
            'truck_id' => 1,
            'user_id' => 16,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 2,
            'user_id' => 10,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 3,
            'user_id' => 4,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 4,
            'user_id' => 7,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 5,
            'user_id' => 9,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 6,
            'user_id' => 5,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 7,
            'user_id' => 8,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 8,
            'user_id' => 17,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 9,
            'user_id' => 6,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 10,
            'user_id' => 11,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 11,
            'user_id' => 3,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 12,
            'user_id' => 12,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 13,
            'user_id' => 19,
        ]);

        DB::table('truck_user')->insert([
            'truck_id' => 14,
            'user_id' => 18,
        ]);
    }
}
