<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authenticatedUser($user = null) {
        $user = $user ?: factory('App\User')->create();
        $this->actingAs($user);
        return $this;
    }
}
