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

        //$this->get($thread->show_url())->assertSee($reply->body);
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);

    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies() {
        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

            $this->authenticatedUser()
                ->delete("/replies/{$reply->id}")
                ->assertStatus(403);

    }

    /** @test */
    public function authorized_users_can_delete_replies() {
        $this->authenticatedUser();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthorized_users_canot_update_replies() {
        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->authenticatedUser()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_edit_replies() {
        $this->authenticatedUser();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedBody = "This is updated body of reply.";
        $this->patch("/replies/{$reply->id}", ['body' => $updatedBody]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedBody]);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created() {
        $this->withoutExceptionHandling();

        $this->authenticatedUser();

        $thread = create('App\Thread');

        $reply = create('App\Reply', [
            'body' => 'vucicu pederu'
        ]);

        //$this->expectException(\Exception::class);

        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function users_may_only_reply_a_maximum_once_per_minute() {
        $this->authenticatedUser();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray())
            ->assertStatus(200);

        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
