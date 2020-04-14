<?php

use App\Models\ChargeRule;
use Illuminate\Database\Seeder;

class ChargeRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = [
            [
                'title' => '租赁多层',
                'rule' => [
                    [
                        'title' => '租赁房租',
                        'fee' => [600, 700, 800, 900],
                        'turn_in' => true,
                        'rate' => 0.3,
                    ],
                    [
                        'title' => '租赁物业费',
                        'fee' => [47.3],
                        'turn_in' => false,
                        'rate' => 0,
                    ],
                ],
                'period' => 3,
            ],
            [
                'title' => '租赁高层',
                'rule' => [
                    [
                        'title' => '租赁房租',
                        'fee' => [700, 800, 900, 1000],
                        'turn_in' => true,
                        'rate' => 0.3,
                    ],
                    [
                        'title' => '租赁物业费',
                        'fee' => [98],
                        'turn_in' => false,
                        'rate' => 0,
                    ],
                    [
                        'title' => '租赁电梯费',
                        'fee' => [40],
                        'turn_in' => false,
                        'rate' => 0,
                    ],
                ],
                'period' => 3,
            ],
            [
                'title' => '单身职工',
                'rule' => [
                    [
                        'title' => '单身床位费',
                        'fee' => [100],
                        'rate' => 0
                    ]
                ],
                'period' => 6,
            ],
            [
                'title' => '超市物业费',
                'rule' => [
                    [
                        'title' => '超市物业费',
                        'fee' => [766],
                        'rate' => 0
                    ]
                ],
                'period' => 1,
            ],
        ];

        foreach ($rules as $rule) {
            ChargeRule::create($rule);
        }
    }
}
