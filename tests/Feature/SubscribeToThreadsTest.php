<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads() {
        $this->authenticatedUser();
        
        $thread = create('App\Thread');

        $this->post($thread->show_url() . '/subscriptions');

        $this->assertCount(1, $thread->subscriptions);
    }
}
