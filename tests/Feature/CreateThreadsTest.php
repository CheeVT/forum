<?php

namespace Tests\Feature;

use App\Thread;
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
    public function authenticated_users_must_confirm_their_email_address_before_creating_threads() {
        //$user = create('App\User', ['email_verified_at' => null]);
        $user = factory('App\User')->states('unverified')->create();
        //dd($user);
        
        $this->publishThread(['user_id' => $user->id], $user)
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', 'You must confirm your email address!');

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
    public function a_thread_requires_a_unique_slug() {
        $this->authenticatedUser();

        $thread = create('App\Thread', ['title' => 'Chee VT', 'slug' => 'chee-vt']);

        $this->assertEquals($thread->slug, 'chee-vt');

        $this->post(route('threads.store'), $thread->toArray());

        $this->assertTrue(Thread::whereSlug('chee-vt-2')->exists());

        $this->post(route('threads.store'), $thread->toArray());

        $this->assertTrue(Thread::whereSlug('chee-vt-3')->exists());
    }

    /** @test */
    function a_thread_requires_a_valid_board() {
        factory('App\Board', 3)->create();

        $this->publishThread(['board_id' => null])
            ->assertSessionHasErrors('board_id');

        $this->publishThread(['board_id' => 5])
            ->assertSessionHasErrors('board_id');
    }

    protected function publishThread($overrides = [], $authenticatedUserOverrides = []) {
        $this->authenticatedUser($authenticatedUserOverrides);
        
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
        
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }
}
