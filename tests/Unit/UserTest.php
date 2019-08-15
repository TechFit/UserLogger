<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testRegisterWithCorrectData()
    {
        Artisan::call('passport:install');

        $data = [
            'nickname' => 'user1101',
            'firstname' => 'TestFirstname',
            'lastname' => 'TestLastname',
            'age' => 25,
            'password' => '12345678'
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response->assertStatus(200);

        $response->assertJson(['success' => ['token' => $response->json('success')['token']]]);
    }

    public function testRegisterWithBadData()
    {
        $data = [
            'nickname' => '',
            'firstname' => 'TestFirstname',
            'lastname' => 'TestLastname',
            'password' => ''
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response->assertStatus(401);

    }

    public function testLoginWithIncorrectData()
    {
        $data = [];

        $headers = [
            'Authorization' => '',
        ];

        $response = $this->json('POST', '/api/login', $data, $headers);

        $response->assertStatus(401);

        $response->assertJson(['error' => "Unauthorised"]);
    }

    public function testLoginWithCorrectData()
    {
        $response = $this->json('POST', '/api/login', [
            'nickname' => 'user1101',
            'password' => '12345678'
        ]);

        $response->assertStatus(200);

        $response->assertJson(['success' => ['token' => $response->json('success')['token']]]);
    }

}
