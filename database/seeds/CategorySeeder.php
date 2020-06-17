<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categories = [
        [
            'title' => '新职工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '收取超费',
        ],
        [
            'title' => '单身职工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '收取超费',
        ],
        [
            'title' => '搬迁职工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '全额收取',
        ],
        [
            'title' => '租赁户',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '全额收取',
        ],
        [
            'title' => '包商公司',
            'type' => Category::TYPE_COMPANY,
            'utility_type' => '全额收取',
        ],
        [
            'title' => '青武包商公司',
            'type' => Category::TYPE_COMPANY,
            'utility_type' => '全额收取',
        ],
        [
            'title' => '外部单位',
            'type' => Category::TYPE_COMPANY,
            'utility_type' => '全额收取',
        ],
        [
            'title' => '功能用房',
            'type' => Category::TYPE_FUNCTIONAL,
            'utility_type' => '无',
        ],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category) {
            Category::create($category);
        }
    }
}
