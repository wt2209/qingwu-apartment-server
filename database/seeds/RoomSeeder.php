<?php

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $this->zhigonggongyu();
        $this->xieligongyu();
        $this->qingwugongyu();
    }

    public function zhigonggongyu()
    {
        $duo = [
            '红1' => ['1', '2'],
            '红2' => ['1', '2', '3'],
            '红3' => ['1', '2', '3', '4'],
            '1' => ['1', '2'],
            '2' => ['1', '2', '3', '4'],
            '3' => ['1', '2', '3',],
            '4' => ['1', '2', '3',],
            '5' => ['1', '2', '3', '4'],
            '6' => ['1', '2', '3', '4'],
            '7' => ['1', '2', '3', '4', '5'],
            '8' => ['1', '2', '3', '4'],
            '9' => ['1', '2', '3', '4'],
            '10' => ['1', '2', '3', '4'],
            '11' => ['1', '2', '3', '4'],
            '12' => ['1', '2', '3', '4'],
            '13' => ['1', '2', '3', '4'],
            '14' => ['1', '2', '3'],
        ];
        $data = [];
        foreach ($duo as $building => $units) {
            foreach ($units as $unit) {
                for ($i = 1; $i <= 6; $i++) {
                    if (in_array($building, ['红2', '红3', '7', '9', '11'])) {
                        $categoryId = 2;
                        $chargeRuleId = 3;
                    } else {
                        $categoryId = 4;
                        $chargeRuleId = 1;
                    }
                    $number = $i === 6 ? 6 : 4;
                    $data[] = [
                        'title' => $building  . '-' . $unit  . '-' . $i . '01',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'number' => $number,
                        'category_id' => $categoryId,
                        'charge_rule_id' => $chargeRuleId,
                    ];
                    $data[] = [
                        'title' => $building  . '-' . $unit  . '-' . $i . '02',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'number' => $number,
                        'category_id' => $categoryId,
                        'charge_rule_id' => $chargeRuleId,
                    ];
                }
            }
        }

        foreach (['高1', '高2', '高3', '高4'] as $building) {
            for ($i = 1; $i <= 20; $i++) {
                if ($i === 13 || $i === 18) continue;
                if ($building === '高1') {
                    if ($i < 3 || $i > 17) continue;

                    if ($i >= 3 && $i <= 7) {
                        $unit = '3-7层';
                    } else if ($i >= 6 && $i <= 10) {
                        $unit = '8-12层';
                    } else {
                        $unit = '14-17层';
                    }
                } else {
                    if ($i >= 1 && $i <= 5) {
                        $unit = '1-5层';
                    } else if ($i >= 6 && $i <= 10) {
                        $unit = '6-10层';
                    } else if ($i >= 11 && $i <= 16) {
                        $unit = '11-16层';
                    } else {
                        $unit = '17-20层';
                    }
                }
                $number = $building === '高2' ? 4 : 1;
                if ($building === '高2') {
                    $categoryId = 2;
                    $chargeRuleId = 3;
                } else {
                    $categoryId = 4;
                    $chargeRuleId = 1;
                }
                $data[] = [
                    'title' => $building . '-' . $i . '01',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '02',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '03',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '04',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
            }
        }
        foreach ($data as $k => $d) {
            $data[$k]['area_id'] = 1;
        }
        DB::table('rooms')->insert($data);
    }

    public function xieligongyu()
    {
        $data = [];
        for ($building = 1; $building <= 4; $building++) {
            for ($floor = 1; $floor <= 17; $floor++) {
                if ($floor >= 1 && $floor <= 3) {
                    $unit = '1-3层';
                } else if ($floor >= 4 && $floor <= 6) {
                    $unit = '4-6层';
                } else if ($floor >= 7 && $floor <= 9) {
                    $unit = '7-9层';
                } else if ($floor >= 10 && $floor <= 12) {
                    $unit = '10-12层';
                } else if ($floor >= 13 && $floor <= 15) {
                    $unit = '13-15层';
                } else {
                    $unit = '16-17层';
                }
                for ($number = 1; $number <= 17; $number++) {
                    $data[] = [
                        'title' => $building . '-' . $floor . str_pad($number, 2, '0', STR_PAD_LEFT),
                        'building' => $building . '#',
                        'unit' => $unit,
                        'number' => 8,
                        'area_id' => 2,
                        'category_id' => 5,
                        'charge_rule_id' => 6,
                    ];
                }
            }
        }
        DB::table('rooms')->insert($data);
    }

    public function qingwugongyu()
    {
        $data = [];
        for ($building = 1; $building <= 5; $building++) {
            if ($building === 2 || $building === 5) {
                $categoryId = 2;
                $chargeRuleId = 4;
                $number = 3;
            } else {
                $categoryId = 5;
                $chargeRuleId = 9;
                $number = 6;
            }
            for ($floor = 1; $floor <= 17; $floor++) {
                if ($floor >= 1 && $floor <= 3) {
                    $unit = '1-3层';
                } else if ($floor >= 4 && $floor <= 6) {
                    $unit = '4-6层';
                } else if ($floor >= 7 && $floor <= 9) {
                    $unit = '7-9层';
                } else if ($floor >= 10 && $floor <= 12) {
                    $unit = '10-12层';
                } else if ($floor >= 13 && $floor <= 15) {
                    $unit = '13-15层';
                } else {
                    $unit = '16-17层';
                }
                for ($n = 1; $n <= 17; $n++) {
                    $data[] = [
                        'title' => $building . '-' . $floor . str_pad($n, 2, '0', STR_PAD_LEFT),
                        'building' => $building . '#',
                        'unit' => $unit,
                        'number' => $number,
                        'area_id' => 3,
                        'category_id' => $categoryId,
                        'charge_rule_id' => $chargeRuleId,
                    ];
                }
            }
        }
        DB::table('rooms')->insert($data);
    }
}
