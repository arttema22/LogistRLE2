<?php

namespace Database\Factories;

use App\Models\Dir\DirService;
use App\Models\Sys\MoonshineUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('-2 week', '-1 day'),
            'owner_id' => MoonshineUser::all()->random(),
            'driver_id' => MoonshineUser::where('moonshine_user_role_id', 3)->get()->random(),
            'service_id' => DirService::all()->random(),
            'comment' => fake()->words(3, true),
        ];
    }
}
