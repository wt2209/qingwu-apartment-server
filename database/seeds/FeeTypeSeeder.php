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
            ['title' => '租赁房租', 'turn_in' => true],
            ['title' => '租赁物业费', 'turn_in' => false],
            ['title' => '租赁电梯费', 'turn_in' => false],
            ['title' => '单身床位费', 'turn_in' => false],
            ['title' => '超市物业费', 'turn_in' => false],
        ];

        foreach ($types as $type) {
            FeeType::create($type);
        }
    }
}
