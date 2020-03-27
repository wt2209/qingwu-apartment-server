<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public $accessToken = '';

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->seed();
    }

    public function withJwt()
    {
        if (!$this->accessToken) {
            $response = $this->postJson('api/auth/login', [
                'username' => 'admin',
                'password' => 'admin888'
            ]);
            $this->accessToken = $response->json('access_token');
        }
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);
        return $this;
    }

    protected function withNoJwt()
    {
        $this->withHeaders([
            'Authorization' => ''
        ]);
        return $this;
    }

    protected function buildQueryUrl($url, $query)
    {
        return $url . '?' . http_build_query($query);
    }

    public function test_authorization()
    {
        $this->getJson('api/rooms')->assertUnauthorized();
        $this->withJwt()->getJson('api/rooms')->assertOk();
    }
}
