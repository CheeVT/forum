<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_cannot_create_new_threads() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $thread = factory('App\Thread')->create();

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_new_threads() {
        $this->authenticatedUser();

        $thread = factory('App\Thread')->create();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->show_url())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
