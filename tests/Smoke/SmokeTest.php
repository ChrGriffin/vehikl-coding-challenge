<?php

namespace Tests\Smoke;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    /**
     * Test that the application returns a valid HTTP code.
     *
     * @return void
     */
    public function testAppReturns200()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
