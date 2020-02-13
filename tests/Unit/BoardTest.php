<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BoardTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
    }

    /** @test */
    public function a_board_consists_of_threads() {
        $board = create('App\Board');
        $thread = create('App\Thread', ['board_id' => $board->id]);

        $this->assertTrue($board->threads->contains($thread));
    }
}
