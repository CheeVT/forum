<?php

namespace Tests\Unit;

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
}
