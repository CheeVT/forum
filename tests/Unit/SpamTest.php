<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    /** @test */
    public function it_checks_for_invalid_keywords() {
        $this->withoutExceptionHandling();

        $spam = new Spam();

        $this->assertFalse($spam->detect('correct body of reply!'));

        $this->expectException('Exception');

        $spam->detect('vucicu pederu!');
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down() {
        $this->withoutExceptionHandling();

        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('aaaaaaaaaaaaaa');
    }
}
