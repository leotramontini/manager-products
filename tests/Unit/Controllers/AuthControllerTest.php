<?php


namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Manager\Models\User;

class AuthControllerTest extends TestCase
{
    public function testLogin()
    {
        $password = $this->faker->password;

        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in"
        ])->assertStatus(200);
    }

    public function testLoginShouldBeFail()
    {
        $password = $this->faker->password;
        $user = factory(User::class)->create();

        $response = $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertJsonStructure([
            "error"
        ])->assertStatus(401);
    }
}
