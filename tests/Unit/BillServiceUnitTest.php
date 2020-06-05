<?php

namespace Tests\Unit;

use App\Services\BillService;
use PHPUnit\Framework\TestCase;

class BillServiceUnitTest extends TestCase
{
    public function test_get_end_date()
    {
        $startDate = '2020-4-30';
        $endDate = BillService::getEndDate($startDate, 1);
        $this->assertEquals('2020-05-29', $endDate);

        $endDate = BillService::getEndDate($startDate, 10);
        $this->assertEquals('2021-02-28', $endDate);

        $endDate = BillService::getEndDate($startDate, 12);
        $this->assertEquals('2021-04-29', $endDate);

        $endDate = BillService::getEndDate('2020-2-29', 12);
        $this->assertEquals('2021-02-28', $endDate);

        $endDate = BillService::getEndDate('2020-1-1', 12);
        $this->assertEquals('2020-12-31', $endDate);

        $endDate = BillService::getEndDate('2019-03-12', 24);
        $this->assertEquals('2021-03-11', $endDate);
    }

    public function test_get_money()
    {
        $money = BillService::getMoney('2020-4-3', '2020-7-2', 800);
        $this->assertEquals(2400, $money);

        $money2 = BillService::getMoney('2020-4-3', '2020-7-1', 800);
        $this->assertEquals(2374.19, $money2);

        $money3 = BillService::getMoney('2020-4-3', '2020-4-30', 800);
        $this->assertEquals(748.39, $money3);

        $money4 = BillService::getMoney('2020-1-30', '2020-2-29', 800);
        $this->assertEquals(800, $money4);

        $money5 = BillService::getMoney('2020-1-30', '2020-2-28', 800);
        $this->assertEquals(772.41, $money5);

        $money6 = BillService::getMoney('2019-1-30', '2019-2-28', 800);
        $this->assertEquals(800, $money6);

        $money7 = BillService::getMoney('2019-1-30', '2019-2-27', 800);
        $this->assertEquals(771.43, $money7);

        $money8 = BillService::getMoney('2019-1-30', '2019-7-30', 800);
        $this->assertEquals(4825.81, $money8);
    }
}
