<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }


    /** @test */
    public function a_user_can_browse_threads() {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
        //$response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_read_single_thread() {

        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_of_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);

    }
}
