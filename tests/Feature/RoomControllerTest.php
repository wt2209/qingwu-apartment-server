<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Category;
use App\Models\Room;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    public function test_authorization()
    {
        $this->getJson('api/rooms')->assertUnauthorized();
        $this->withJwt()->getJson('api/rooms')->assertOk();
    }

    public function test_get_rooms_paginator_without_query()
    {
        $perPage = config('app.pageSize');
        $response = $this->withJwt()->getJson('api/rooms');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
        $total = Room::count();
        if ($total >= $perPage) {
            $response->assertJsonCount($perPage, 'data');
        } else {
            $response->assertJsonCount($total, 'data');
        }
    }

    public function test_get_rooms_paginator_with_trashed()
    {
        Room::first()->delete();
        $response = $this->withJwt()->getJson('api/rooms');
        $data = $response->json('data');
        $this->assertNotNull($data[0]['deleted_at']);
        $this->assertNull($data[1]['deleted_at']);
    }

    public function test_get_rooms_paginator_with_query()
    {
        $perPage = 3;
        $building1 = '1';

        $query1 = [
            'pageSize' => $perPage,
            'building' => $building1,
        ];
        $response1 = $this->withJwt()->getJson($this->buildQueryUrl('api/rooms', $query1));
        $response1->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount($perPage, 'data');

        $title2 = '1-1-101';
        $response2 = $this->withJwt()->getJson($this->buildQueryUrl('api/rooms', ['title' => $title2]));
        $response2->assertOk()
            ->assertJsonCount(1, 'data');

        $allQuerys = [
            'area_id' => [],
            'category_id' => [],
            'title' => '1-1-',
            'building' => '1',
            'unit' => '2单元',
            'pageSize' => 30,
            'page' => 1
        ];
        $url3 = $this->buildQueryUrl('api/rooms', $allQuerys);
        $response3 = $this->withJwt()->getJson($url3);
        $response3->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_show_a_room()
    {
        $room = Room::first();
        $response = $this->withJwt()->getJson("api/rooms/{$room->id}");
        $response->assertOk()
            ->assertJsonStructure(['data']);
        $data = $response->json('data');
        $this->assertEquals($data['title'], $room->title);
    }

    public function test_create_a_room()
    {
        $area = Area::first();
        $category = Category::first();
        $data = [
            'title' => '',
            'area_id' => $area->id,
            'building' => '1#',
            'unit' => '1单元',
            'category_id' => $category->id,
            'number' => 0,
        ];
        $response1 = $this->withJwt()->postJson('api/rooms', $data);
        $response1->assertStatus(422)->assertJsonStructure(['error']);

        $data2 = [
            'title' => '1-1-1011',
            'building' => '1#',
            'unit' => '1单元',
            'area_id' => $area->id,
            'category_id' => $category->id,
            'number' => 1,
        ];
        $response2 = $this->withJwt()->postJson('api/rooms', $data2);
        $response2->assertStatus(201)->assertJsonStructure(['message']);
    }

    public function test_update_a_room()
    {
        $area = Area::first();
        $category = Category::first();
        $room = Room::first();
        $data1 = [
            'title' => '',
            'building' => '1#',
            'unit' => '1单元',
            'area_id' => $area->id,
            'category_id' => $category->id,
            'number' => 0,
        ];
        $response1 = $this->withJwt()->putJson("api/rooms/{$room->id}", $data1);
        $response1->assertStatus(422);

        $data2 = [
            'title' => '1-1-103',
            'building' => '1#',
            'unit' => '1单元',
            'area_id' => $area->id,
            'category_id' => $category->id,
            'number' => 0,
        ];
        $response2 = $this->withJwt()->putJson("api/rooms/{$room->id}", $data2);
        $response2->assertOk()->assertJsonStructure(['message']);
    }

    public function test_delete_a_room()
    {
        $area = Area::first();
        $room = Room::first();
        $response = $this->withJwt()->deleteJson("api/rooms/{$room->id}");
        $response->assertOk();

        $trashedRoom = Room::withTrashed()->find($room->id);
        $this->assertNotNull($trashedRoom);
    }
}
