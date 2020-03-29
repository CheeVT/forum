<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
    }

    /** @test */
    function it_has_a_creator() {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->user);
    }

    /** @test */
    public function it_knows_if_it_was_just_published() {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_reply() {
        $reply = create('App\Reply', [
            'body' => '@CheeVT wants to be a good programer, @missmudrica believes in him.'
        ]);

        $this->assertEquals(['CheeVT', 'missmudrica'], $reply->mentionedUsers());
    }
}
