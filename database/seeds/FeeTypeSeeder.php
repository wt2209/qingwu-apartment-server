<?php

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => '租赁房租', 'turn_in' => true, 'rate' => 0.3],
            ['title' => '租赁物业费', 'turn_in' => false, 'rate' => 0],
            ['title' => '租赁电梯费', 'turn_in' => false, 'rate' => 0],
            ['title' => '租赁电费', 'turn_in' => true, 'rate' => 0],
            ['title' => '租赁水费', 'turn_in' => true, 'rate' => 0],
            ['title' => '单身床位费', 'turn_in' => true, 'rate' => 0],
            ['title' => '服务费', 'turn_in' => true, 'rate' => 0],
            ['title' => '超市物业费', 'turn_in' => true, 'rate' => 0],
            ['title' => '超市电费', 'turn_in' => true, 'rate' => 0],
        ];

        foreach ($types as $type) {
            FeeType::create($type);
        }
    }
}
