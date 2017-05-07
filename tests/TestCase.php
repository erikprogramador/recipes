<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected function signIn($overrides = [])
    {
        $this->user = factory(User::class)->create($overrides);
        $this->be($this->user);

        return $this;
    }
}
