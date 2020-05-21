<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Manager\Models\User;
use Manager\Models\Status;

class StatusControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->baseResource = '/api/status';
        $user = factory(User::class)->create();
        $this->token = auth()->login($user);
    }

    public function testGetAllStatus()
    {
        $status = factory(Status::class)->create();

        $expected = [
            'data' => [
                [
                    'id'    => $status->id,
                    'name'  => $status->name,
                    'alias' => $status->alias
                ]
            ]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('GET', $this->baseResource . '/all');
        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testGetAllStatusShouldBeFail()
    {
        $expected = [
            'message',
            'status_code'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('GET', $this->baseResource . '/all');

        $response->assertJsonStructure($expected)
            ->assertStatus(400);
    }
}
