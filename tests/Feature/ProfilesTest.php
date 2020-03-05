<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_has_a_profile() {
        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_by_owner() {
        $this->authenticatedUser();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get(route('profiles.show', auth()->user()))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
