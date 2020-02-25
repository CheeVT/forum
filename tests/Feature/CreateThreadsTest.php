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

        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    function guest_cannot_see_the_create_thread_page() {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_threads() {
        $this->authenticatedUser();

        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->show_url())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title() {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body() {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_board() {
        factory('App\Board', 3)->create();

        $this->publishThread(['board_id' => null])
            ->assertSessionHasErrors('board_id');

        $this->publishThread(['board_id' => 5])
            ->assertSessionHasErrors('board_id');
    }

    protected function publishThread($overrides = []) {
        $this->authenticatedUser();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function unauthorized_users_cannot_delete_threads() {
        $thread = create('App\Thread');
        $this->delete($thread->show_url())
            ->assertRedirect('/login');

        $this->authenticatedUser();
        $this->delete($thread->show_url())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads() {
        $this->authenticatedUser();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->show_url())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
