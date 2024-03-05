<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'user_id' => 1,
            'last_name' => 'Гусев',
            'first_name' => 'Артем',
            'middle_name' => 'Александрович',
            'phone' => '79119268188',
        ]);
    }
}
