<?php

namespace Tests\Feature;

use App\Models\Area;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AreaControllerTest extends TestCase
{
    public function test_get_areas()
    {
        $perPage = config('app.per_page');
        $response = $this->withJwt()->getJson('api/areas');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);

        $total = Area::count();
        if ($total >= $perPage) {
            $response->assertJsonCount($perPage, 'data');
        } else {
            $response->assertJsonCount($total, 'data');
        }
    }

    public function test_get_one_area()
    {
        $id = 1;
        $area = Area::find($id);
        $result = [
            'data' => [
                'id' => $area->id,
                'title' => $area->title,
                'description' => $area->description,
            ]
        ];
        $response = $this->withJwt()->getJson('api/areas/' . $id);
        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJson($result);
    }

    public function test_create_one_area()
    {
        $area = [
            'title' => '测试区域',
            'description' => '测试区域的说明',
        ];
        $count = Area::count();

        $this->withJwt()->postJson('api/areas', $area)
            ->assertStatus(201)
            ->assertJsonStructure(['message']);
        $this->assertEquals(Area::count(), $count + 1);

        $errorArea = [
            'title' => '',
        ];
        $this->withJwt()->postJson('api/areas', $errorArea)
            ->assertStatus(422);
    }

    public function test_update_one_area()
    {
        $area = Area::create([
            'title' => '测试区域',
            'description' => '测试区域的说明',
        ]);

        $this->assertEquals(1, Area::where('title', '测试区域')->count());

        $this->withJwt()->putJson('api/areas/' . $area->id, ['title' => '测试区域1'])
            ->assertStatus(200);

        $this->assertEquals(0, Area::where('title', '测试区域')->count());
        $this->assertEquals(1, Area::where('title', '测试区域1')->count());
    }

    public function test_soft_delete_one_area()
    {
        $count = Area::count();
        $this->withJwt()->deleteJson('api/areas/1')
            ->assertStatus(200);
        $this->assertEquals($count - 1, Area::count());
        $this->assertEquals($count, Area::withTrashed()->count());
    }
}
