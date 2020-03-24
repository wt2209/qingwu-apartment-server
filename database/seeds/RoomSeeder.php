<?php

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    private $duo = [
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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        foreach ($this->duo as $building => $units) {
            foreach ($units as $unit) {
                for ($i = 1; $i <= 6; $i++) {
                    $number = $i === 6 ? 6 : 4;
                    $data[] = [
                        'title' => $building  . '-' . $unit  . '-' . $i . '01',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'rent' => 0,
                        'number' => $number,
                    ];

                    $data[] = [
                        'title' => $building  . '-' . $unit  . '-' . $i . '02',
                        'building' => $building . '#',
                        'unit' => $unit . '单元',
                        'rent' => 0,
                        'number' => $number,
                    ];
                }
            }
        }

        foreach (['高1', '高2', '高3', '高4'] as $building) {
            for ($i = 1; $i < 20; $i++) {
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

                $data[] = [
                    'title' => $building . '-' . $i . '01',
                    'building' => $building,
                    'unit' => $unit,
                    'rent' => 0,
                    'number' => $number,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '02',
                    'building' => $building,
                    'unit' => $unit,
                    'rent' => 0,
                    'number' => $number,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '03',
                    'building' => $building,
                    'unit' => $unit,
                    'rent' => 0,
                    'number' => $number,
                ];
                $data[] = [
                    'title' => $building . '-' . $i . '04',
                    'building' => $building,
                    'unit' => $unit,
                    'rent' => 0,
                    'number' => $number,
                ];
            }
        }

        foreach ($data as  $d) {
            $d['area_id'] = 1;
            $d['category_id'] = rand(1, 7);
            Room::create($d);
        }
    }
}
