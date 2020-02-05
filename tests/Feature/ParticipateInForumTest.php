<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        //$this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $this->post('/threads/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads() {
        //$this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $this->be($user);

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        //$response->assertRedirect('/threads/' . $thread);
        //$response->assertRedirect($thread->show_url());

        $this->get($thread->show_url())->assertSee($reply->body);
        //$this->get($thread->show_url())->assertSee($reply->body);
    }
}
