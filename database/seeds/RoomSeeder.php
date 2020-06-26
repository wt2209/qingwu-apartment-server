<?php

use App\Models\Area;
use App\Models\Category;
use App\Models\ChargeRule;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RoomSeeder extends Seeder
{
    public $areaMapper;
    protected $categoryMapper;
    protected $chargeRuleMapper;

    public function __construct()
    {
        $this->areaMapper = Area::pluck('id', 'title');
        $this->categoryMapper = Category::pluck('id', 'title');
        $this->chargeRuleMapper = ChargeRule::pluck('id', 'title');
    }

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
        $areaId = $this->areaMapper['职工公寓'];
        foreach ($duo as $building => $units) {
            foreach ($units as $unit) {
                for ($i = 1; $i <= 6; $i++) {
                    if (in_array($building, ['红2', '红3', '7', '9', '11'])) {
                        $categoryId = $this->categoryMapper['单身职工'];
                        $chargeRuleId = $this->chargeRuleMapper['A区单身职工'];
                    } else {
                        $categoryId =  $this->categoryMapper['租赁户'];
                        $chargeRuleId = $this->chargeRuleMapper['租赁多层'];
                    }
                    if (in_array($building, ['1', '2', '3', '4', '5', '6', '8', '10', '12', '14', '红1'])) {
                        $number = 1;
                    } else {
                        $number = $i === 6 ? 6 : 4;
                    }
                    $data[] = [
                        'id' => Uuid::uuid4()->toString(),
                        'title' => $building  . '-' . $unit  . '-' . $i . '01',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'number' => $number,
                        'area_id' => $areaId,
                        'category_id' => $categoryId,
                        'charge_rule_id' => $chargeRuleId,
                    ];
                    $data[] = [
                        'id' => Uuid::uuid4()->toString(),
                        'title' => $building  . '-' . $unit  . '-' . $i . '02',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'number' => $number,
                        'area_id' =>  $areaId,
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
                    $categoryId = $this->categoryMapper['单身职工'];
                    $chargeRuleId = $this->chargeRuleMapper['A区单身职工'];
                } else {
                    $categoryId = $this->categoryMapper['租赁户'];
                    $chargeRuleId = $this->chargeRuleMapper['租赁多层'];
                }
                $data[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'title' => $building . '-' . $i . '01',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'area_id' =>  $areaId,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'title' => $building . '-' . $i . '02',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'area_id' =>  $areaId,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'title' => $building . '-' . $i . '03',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'area_id' =>  $areaId,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
                $data[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'title' => $building . '-' . $i . '04',
                    'building' => $building,
                    'unit' => $unit,
                    'number' => $number,
                    'area_id' =>  $areaId,
                    'category_id' => $categoryId,
                    'charge_rule_id' => $chargeRuleId,
                ];
            }
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
                        'id' => Uuid::uuid4()->toString(),
                        'title' => $building . '-' . $floor . str_pad($number, 2, '0', STR_PAD_LEFT),
                        'building' => $building . '#',
                        'unit' => $unit,
                        'number' => 8,
                        'area_id' => $this->areaMapper['协力公寓'],
                        'category_id' => $this->categoryMapper['包商公司'],
                        'charge_rule_id' => $this->chargeRuleMapper['协力公寓8人间'],
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
                $categoryId = $this->categoryMapper['单身职工'];
                $chargeRuleId = $this->chargeRuleMapper['B区单身职工'];
                $number = 2;
            } else {
                $categoryId = $this->categoryMapper['青武包商公司'];
                $chargeRuleId = $this->chargeRuleMapper['青武公寓6人间'];
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
                        'id' => Uuid::uuid4()->toString(),
                        'title' => $building . '-' . $floor . str_pad($n, 2, '0', STR_PAD_LEFT),
                        'building' => $building . '#',
                        'unit' => $unit,
                        'number' => $number,
                        'area_id' => $this->areaMapper['青武公寓'],
                        'category_id' => $categoryId,
                        'charge_rule_id' => $chargeRuleId,
                    ];
                }
            }
        }
        DB::table('rooms')->insert($data);
    }
}
