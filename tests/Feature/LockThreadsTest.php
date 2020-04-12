<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_administrator_can_lock_any_threads() {
        $this->authenticatedUser();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post(route('replies.store', [$thread->board, $thread]), [
            'body' => 'new comment',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
