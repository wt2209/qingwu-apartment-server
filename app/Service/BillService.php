<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Category;
use App\Models\Record;

class BillService
{

    /**
     * @param $record 一条记录
     * @param $endDate 本期费用结束日期
     * @param $recordAt 最初开始收费的日期（入住日期）
     */
    public static function generateBills($record, $startDate, $endDate)
    {
        // 收费规则
        $rules = $record['charge_rule']['rule'];
        // 入住日期：有租期，则以租期作为入住日期，无租期，则使用入住日期
        if (isset($record['rent_start']) && strtotime($record['rent_start'])) {
            $recordAt = formatDate($record['rent_start']);
        } else {
            $recordAt = formatDate($record['record_at']);
        }

        $yearNumber = 1; // 第几年
        $crossYear = false; //是否跨年
        $lastEnd = $recordAt; // 最后一个与recordAt对应的整数年
        while (true) {
            // 按租期开始日计算的整年的时间
            $lastEnd = self::getEndDate($recordAt, $yearNumber * 12);
            if (strtotime($lastEnd) > strtotime($startDate)) { // 第一次大于$startDate 时，停止循环
                // 计算开始日期和结束日期是否跨一整年
                if (strtotime($lastEnd) < strtotime($endDate)) {
                    $crossYear = true;
                }
                break;
            }
            $yearNumber++;
        }
        $bills = [];
        foreach ($rules as $rule) {
            $index = min($yearNumber, count($rule['fee']) - 1);
            $rent = $rule['fee'][$index];
            if ($crossYear) { // $startDate < $lastEnd < $endDate
                $nextRent = $rule['fee'][min($yearNumber + 1, count($rule['fee']) - 1)];
                $money = self::getMoney($startDate, $lastEnd, $rent) + self::getMoney($lastEnd, $endDate, $nextRent);
            } else { // $startDate < $endDate < $lastEnd
                $money = self::getMoney($startDate, $endDate, $rent);
            }
            // 与整数相差小于0.1元时，直接取整。解决 42.33 * 3 ！== 142 的问题。
            if (abs(round($money, 0) - $money) <= 0.1) {
                $money = round($money, 0);
            }
            switch ($record['type']) {
                case Category::TYPE_PERSON:
                    $name = $record['person']['name'];
                    break;
                case Category::TYPE_COMPANY:
                    $name = $record['company']['company_name'];
                    break;
                default:
                    $name = '';
            }
            $bills[] = [
                'area_id' => $record['area_id'],
                'way' => Bill::WAY_BEFORE,
                'type' => $record['type'],
                'location' => $record['room']['title'],
                'name' => $name,
                'title' => $rule['title'],
                'turn_in' => $rule['turn_in'],
                'money' => $money,
                'description' => "{$startDate}—{$endDate}",
                'late_base' => $nextRent ?? $rent,
                'late_date' => $endDate,
                'late_rate' => $rule['rate'],
                'should_charge_at' => date('Y-m-d', strtotime('-1 day', strtotime($endDate))),
                'is_refund' => false,
                'auto_generate' => true,
            ];
        }
        return $bills;
    }

    public static function getMoney($start, $end, $rent)
    {
        $money = 0;
        $period = 1;
        while (true) {
            $nextEnd = self::getEndDate($start, $period);
            if (strtotime($nextEnd) < strtotime($end)) { // 一整月
                $money += $rent;
                $period++;
            } else if (strtotime($nextEnd) === strtotime($end)) { // 正好一整月，不用继续了
                $money += $rent;
                break;
            } else { // 不足一整月，需要减去不足的部分
                // 两个日期相差的天数
                $dayNumber = (strtotime($nextEnd) - strtotime($end)) / (3600 * 24);
                $total = (int) date('t', strtotime($nextEnd));
                $money += ($rent - round($dayNumber / $total * $rent, 2));
                break;
            }
        }
        return round($money, 2);
    }

    public static function getEndDate($startDate, $period)
    {
        $startDay = (int) date('d', strtotime($startDate));
        $startMonth = (int) date('m', strtotime($startDate));

        $endMonth = intval(($startMonth + $period - 1) % 12) + 1;
        $endYear = (int) date('Y', strtotime($startDate));
        if (($startMonth + $period) / 12 > 1) { // 需要加1年
            $endYear += intval(($startMonth + $period) / 12);
        }
        $lastDayOfMonth = (int) date('t', strtotime("{$endYear}-{$endMonth}-1"));
        if ($lastDayOfMonth < $startDay) { // 月末小于开始日期的最后的天数，主要是处理2月份
            $endDate = formatDate("{$endYear}-{$endMonth}-{$lastDayOfMonth}");
        } else {
            $endDate = formatDate("{$endYear}-{$endMonth}-{$startDay}");
            // 将日期减去1天，得出类似 2020-3-4 —— 2020-4-3 的格式，而不是2020-4-4
            $endDate = date('Y-m-d', strtotime('-1 day', strtotime($endDate)));
        }

        return $endDate;
    }
}
