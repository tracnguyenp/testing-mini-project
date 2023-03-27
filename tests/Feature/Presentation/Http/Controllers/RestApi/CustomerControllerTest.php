<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use TestingAspire\Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    // use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('passport:install', [
            '--force' => true,
        ]);
        Artisan::call('passport:client', [
            '--personal' => true,
            '--quiet' => true,
        ]);
    }

    protected function tearDown(): void
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->post('/api/customers/register', [
            'name' => 'test05@yahoo.com',
        ]);
        // Expect 400 returned because of missing data
        $response->assertStatus(400);

        $response = $this->post('/api/customers/register', [
            'name' => 'test92@yahoo.com',
            'email' => 'test92@yahoo.com',
            'password' => '123456',
        ]);
        $response->assertOk();

        $response = $this->post('/api/customers/register', [
            'name' => 'test92@yahoo.com',
            'email' => 'test92@yahoo.com',
            'password' => '123456',
        ]);
        // Expect 400 returned because of dupplicated email
        $response->assertStatus(400);
    }

    public function test_login()
    {
        $response = $this->post('/api/customers/register', [
            'name' => 'test92@yahoo.com',
            'email' => 'test92@yahoo.com',
            'password' => '123456',
        ]);
        $response->assertOk();

        $response = $this->post('/api/customers/login', [
            'email' => 'test92@yahoo.com',
            'password' => '123456',
        ]);
        $accessToken = $response->decodeResponseJson()->json('access_token');
        $response->assertOk();
        $this->assertNotEmpty($accessToken);
    }
}
