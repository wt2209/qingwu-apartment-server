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
            'charge_rule' => [],
        ],
        [
            'title' => '单身职工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '收取超费',
            'charge_rule' => [],
        ],
        [
            'title' => '搬迁职工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '全额收取',
            'charge_rule' => [],
        ],
        [
            'title' => '派遣工',
            'type' => Category::TYPE_PERSON,
            'utility_type' => '收取超费',
            'charge_rule' => [],
        ],
        [
            'title' => '包商公司',
            'type' => Category::TYPE_COMPANY,
            'utility_type' => '全额收取',
            'charge_rule' => [],
        ],
        [
            'title' => '外部单位',
            'type' => Category::TYPE_COMPANY,
            'utility_type' => '全额收取',
            'charge_rule' => [],
        ],
        [
            'title' => '仓库',
            'type' => Category::TYPE_FUNCTIONAL,
            'utility_type' => '无',
            'charge_rule' => [],
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
