<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    	$this->artisan('migrate:fresh');
    	$this->seed();
    }
}