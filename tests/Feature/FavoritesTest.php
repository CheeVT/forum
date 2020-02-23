<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guests_can_not_favorite_reply() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $this->post('replies/1/favorites');
        $this->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply() {
        $this->authenticatedUser();

        $reply = factory('App\Reply')->create();

        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once() {
        $this->authenticatedUser();

        $reply = create('App\Reply');

        try {
            $this->post("/replies/{$reply->id}/favorites");
            $this->post("/replies/{$reply->id}/favorites");
        } catch (\Exception $e) {
            $this->fail('Cannot favorite a same reply twice!');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
