<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutentificationTest extends TestCase
{

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_login()
    {
        $response = $this->post('/login', [
            'username' => 'arttema@mail.ru',
            'password' => '1234qwerQWER',
        ]);

        //$this->assertAuthenticated();
        //$response->assertRedirect(RouteServiceProvider::HOME);
    }
}
