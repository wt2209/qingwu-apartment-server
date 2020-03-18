<?php

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            ['title' => '职工公寓'],
            ['title' => '协力公寓'],
            ['title' => '青武公寓'],
        ];
        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
