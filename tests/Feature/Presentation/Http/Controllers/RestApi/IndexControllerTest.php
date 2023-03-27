<?php

namespace Tests\Feature;

use TestingAspire\Tests\TestCase;

class IndexControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_home()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Welcome to Testing Aspire fron npbtrac@gmail Rest API',
        ]);
    }
}
