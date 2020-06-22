<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Record;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function living(Request $request)
    {
        $areas = $request->query('areas', []);
        $categories = $request->query('categories', []);
        $types = $request->query('types', []);
        $roomTitle = $request->query('room', '');

        $roomQb = Room::select(['id', 'area_id', 'category_id']);
        $peopleQb = Record::select(['id', 'area_id', 'category_id', 'type'])->where('type', 'person');
        if ($areas) {
            $roomQb->whereIn('area_id', $areas);
        }
        if ($categories) {
            $roomQb->whereIn('category_id', $categories);
        }
        if ($types) {
            $ids = Category::whereIn('type', $types)->pluck('id');
            $roomQb->whereIn('category_id', $ids);
        }
        if ($roomTitle) {
            $roomIds = Room::where('title', 'like', "%{$roomTitle}%")->pluck('id');
            $roomQb->whereIn('id', $roomIds);
            $peopleQb->whereIn('room_id', $roomIds);
        }

        $roomAllCount = $roomQb->get()->countBy(function ($record) {
            return $record['area_id'] . '_' . $record['category_id'];
        });

        $usedRoomIds = Record::pluck('room_id');
        $roomUsedCount = $roomQb->whereIn('id', $usedRoomIds)
            ->get()
            ->countBy(function ($record) {
                return $record['area_id'] . '_' . $record['category_id'];
            });

        $peopleCount = $peopleQb->get()
            ->countBy(function ($record) {
                return $record['area_id'] . '_' . $record['category_id'];
            });

        $companiesCount = Record::where('type', 'company')->distinct('company_id')->get()->countBy(function ($record) {
            return $record['area_id'] . '_' . $record['category_id'];
        });

        $categoryMapper = Category::pluck('title', 'id')->toArray();
        $areaMapper = Area::pluck('title', 'id')->toArray();

        $result = [];
        foreach ($roomAllCount as $key => $count) {
            $arr = explode('_', $key);
            $area = $areaMapper[$arr[0]];
            $category = $categoryMapper[$arr[1]];
            $data = [
                'area' => $area,
                'category' => $category,
                'rooms_all_count' => $count,
            ];
            $data['rooms_used_count'] = $roomUsedCount[$key] ?? 0;
            $data['rooms_empty_count'] = $data['rooms_all_count'] - $data['rooms_used_count'];
            $data['people_count'] = $peopleCount[$key] ?? '';
            $data['companies_count'] = $companiesCount[$key] ?? '';
            $result[] = $data;
        }

        usort($result, function ($a, $b) {
            return $a['area'] > $b['area'];
        });

        return response()->json(['data' => $result]);
    }

    public function bill(Request $request)
    {
        $start = $request->query('start', null);
        $end = $request->query('start', null);
        $areas = $request->query('areas', null);
        $feeTypes = $request->query('fee_types', null);
        $location = $request->query('location', null);
        $name = $request->query('name', null);
        $turnIn = $request->query('turn_in', 'all');
        $isRefund = $request->query('is_refund', 0);

        $qb = Bill::select(['title', DB::raw('sum(money) as money')])
            ->whereNotNull('charged_at');

        if (strtotime($start)) {
            $qb->where('charged_at', '>=', date('Y-m-d', strtotime($start)));
        }
        if (strtotime($end)) {
            $qb->where('charged_at', '<', date('Y-m-d', strtotime('+1 days', strtotime($end))));
        }
        if ($areas) {
            $qb->whereIn('area_id', $areas);
        }
        if ($feeTypes) {
            $qb->whereIn('title', $feeTypes);
        }
        if ($location) {
            $qb->where('location', 'like', "%{$location}%");
        }
        if ($name) {
            $qb->where('name', 'like', "%{$name}%");
        }
        if ($turnIn === 'yes' || $turnIn === 'no') {
            $qb->where('turn_in', $turnIn === 'yes');
        }
        $qb->where('is_refund', !!$isRefund);


        return response()->json(['data' => $qb->groupBy('title')->get()]);
    }
}
