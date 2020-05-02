<?php

namespace Tests\Unit;

use App\Reply;
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

    /** @test */
    public function it_wraps_mentioned_names_in_the_body_within_anchor_tag() {
        $reply = new Reply([
            'body' => 'Hello @CheeVT.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/CheeVT">@CheeVT</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_knows_if_it_is_the_best_reply() {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function a_reply_body_is_senitized_automatically() {
        $reply = make('App\Reply', ['body' => '<script>alert("test")</script><p>Hello world!</p>']);

        $this->assertEquals('<p>Hello world!</p>', $reply->body);
    }
}
