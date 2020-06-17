<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Category;
use App\Models\ChargeRule;
use App\Models\Record;
use App\Models\Room;
use App\Services\BillService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class BillControllerTest extends TestCase
{
    public function test_generate_bills()
    {
        $category = Category::where('type', 'person')->first();
        $room = Room::where('area_id', 1)->where('category_id', $category->id)->first();
        $chargeRule = ChargeRule::where('type', 'person')->first();
        $record = [
            'area_id' => 1,
            'type' => 'person',
            'category_id' => $category->id,
            'room_id' => $room->id,
            'person' => [
                'name' => '张三',
            ],
            'charge_rule_id' => $chargeRule->id,
            'record_at' => '2020-3-12',
            'charged_to' => '2020-6-12',
        ];
        $response = $this->withJwt()->postJson('api/livings', $record);
        $response->assertStatus(201);

        $res = $this->withJwt()->postJson('/api/bills/generate', [
            'date' => '2020-12-30',
            'export' => '1',
            'save' => '1',
        ]);

        $res->assertStatus(200);
    }
}
