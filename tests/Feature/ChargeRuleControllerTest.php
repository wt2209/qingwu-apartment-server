<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChargeRuleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_charge_rules()
    {
        $this->withJwt()->getJson('api/charge-rules')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
