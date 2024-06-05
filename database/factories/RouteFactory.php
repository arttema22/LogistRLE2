<?php

namespace Database\Factories;

use App\Models\Dir\DirCargo;
use App\Models\Sys\MoonshineUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
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
            'cargo_id' => DirCargo::all()->random(),
            'address_loading' => Fake()->text(5),
            'address_unloading' => Fake()->text(8),
            'number_trips' => Fake()->numberBetween(1, 2),
            'comment' => fake()->words(3, true),
        ];
    }
}
