<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testTrackAction()
    {

        $data = [
            'source_label' => "test_done",
        ];

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/track/add', $data);

        $response->assertStatus(200);

        $response->assertJson(['success' => true]);

        $response->assertJson(['message' => 'Tracked.']);
    }
}
