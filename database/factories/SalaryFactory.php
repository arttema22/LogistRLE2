<?php

namespace Database\Factories;

use Faker\Core\Number;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Number as SupportNumber;
use MoonShine\Models\MoonshineUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => now(),
            'owner_id' => MoonshineUser::all()->random(),
            'driver_id' => MoonshineUser::where('moonshine_user_role_id', 3)->get()->random(),
            'salary' => 25000,
            'profit_id' => 0,
            'deleted_at' => now(),
        ];
    }
}
