<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_get_categoroies()
    {
        $perPage = config('app.pageSize');
        $response = $this->withJwt()->getJson('api/categories');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);

        $total = Category::count();
        if ($total >= $perPage) {
            $response->assertJsonCount($perPage, 'data');
        } else {
            $response->assertJsonCount($total, 'data');
        }
    }

    public function test_get_categoroies_with_query()
    {

        $perPage = config('app.pageSize');
        $response = $this->withJwt()->getJson('api/categories');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);

        $total = Category::count();
        if ($total >= $perPage) {
            $response->assertJsonCount($perPage, 'data');
        } else {
            $response->assertJsonCount($total, 'data');
        }

        $category = Category::create([
            'title' => '新建的一个类型',
            'type' => Category::TYPE_PERSON,
        ]);

        $query = [
            'title' => '新建的一个类型',
        ];
        $this->withJwt()->getJson($this->buildQueryUrl('api/categories', $query))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_get_one_category()
    {
        $category = Category::first();
        $result = [
            'data' => [
                'id' => $category->id,
                'title' => $category->title,
                'type' => $category->type,
            ]
        ];
        $this->withJwt()->getJson('api/categories/' . $category->id)
            ->assertStatus(200)
            ->assertJson($result);
    }

    public function test_create_one_category()
    {
        $count = Category::count();
        $category = [
            'title' => '新建的一个类型',
            'type' => Category::TYPE_COMPANY,
        ];

        $this->withJwt()->postJson('api/categories', $category)
            ->assertStatus(201)
            ->assertJsonStructure(['message']);
        $this->assertEquals(Category::count(), $count + 1);
        $this->withJwt()->getJson($this->buildQueryUrl('api/categories', ['title' => '新建的一个类型']))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');

        $errorCategory = [
            'title' => '',
        ];
        $this->withJwt()->postJson('api/categories', $errorCategory)
            ->assertStatus(422);
    }

    public function test_update_one_category()
    {
        $item = Category::create([
            'title' => '测试类型',
            'type' => Category::TYPE_PERSON,
        ]);

        $this->withJwt()->putJson('api/categories/' . $item->id, [
            'title' => '测试类型1',
            'type' => Category::TYPE_COMPANY,
        ])
            ->assertStatus(200);

        $this->withJwt()->getJson('api/categories/' . $item->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => '测试类型1',
                    'type' => Category::TYPE_COMPANY,
                ]
            ]);

        $this->assertEquals(0, Category::where('title', '测试区域')->count());
        $this->assertEquals(1, Category::where('title', '测试类型1')->count());
    }

    public function test_soft_delete_one_category()
    {
        $count = Category::count();
        $category = Category::first();
        $this->withJwt()->deleteJson("api/categories/{$category->id}")
            ->assertStatus(200);
        $this->assertEquals($count - 1, Category::count());
        $this->assertEquals($count, Category::withTrashed()->count());
    }
}
