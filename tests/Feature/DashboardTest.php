<?php

namespace Tests\Feature;

use App\Models\Sys\MoonshineUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDashboard(): void
    {
        $user = MoonshineUser::find(2);

        $response = $this->actingAs($user)->get('/');

        $response->dump();

        //$response->assertStatus(302);
    }
}
