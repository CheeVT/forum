<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified() {
        $cheeVT = create('App\User', ['name' => 'CheeVT']);

        $this->authenticatedUser($cheeVT);

        $missmudrica = create('App\User', ['name' => 'missmudrica']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Hey @missmudrica, look at that nice sneaker from @nike factory :-)'
        ]);

        $this->post('/threads/' . $thread->board->slug . '/' . $thread->slug . '/replies', $reply->toArray());

        $this->assertCount(1, $missmudrica->notifications);
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters() {
        create('App\User', ['name' => 'CheeVT']);
        create('App\User', ['name' => 'CheeVT2']);
        create('App\User', ['name' => 'VTChee']);
        
        $result = $this->json('GET', '/api/users?query=Chee');

        $this->assertCount(2, $result->json());
    }
}
