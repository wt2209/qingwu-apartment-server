<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeeTypeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_fee_types()
    {
        $this->withJwt()->getJson('api/fee-types')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
