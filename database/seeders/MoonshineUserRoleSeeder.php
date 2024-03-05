<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use MoonShine\Models\MoonshineUserRole;
use Illuminate\Support\Facades\Hash;
use MoonShine\Models\MoonshineUser;

class MoonshineUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MoonshineUserRole::create([
            'name' => 'Администратор'
        ]);

        MoonshineUserRole::create([
            'name' => 'Водитель'
        ]);
    }
}
