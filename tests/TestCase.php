<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('cache:forget', ['key' => 'spatie.permission.cache']);
        $this->artisan('config:clear');
    }
}
