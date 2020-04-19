<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LivingResource;
use App\Models\Area;
use App\Models\Room;
use Illuminate\Http\Request;

class LivingController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = config('app.pageSize', 20);
        $area = $request->query('area', '');
        $building = $request->query('building', '');
        $unit = $request->query('unit', '');

        $keyword = $request->query('keyword', '');
        $areaId = $request->query('area_id', 0);

        $qb = Room::with([
            'area',
            'category',
            'records',
            'records.person',
            'records.company',
            'records.category'
        ]);

        // 楼号选择
        if ($area && $building && $unit) {
            $areaId = Area::where('title', $area)->value('id');
            $rooms = $qb->where('area_id', $areaId)
                ->where('building', $building)
                ->where('unit', $unit)
                ->paginate($pageSize);
            return LivingResource::collection($rooms);
        }

        // 搜索
        if ($keyword) {
            if ($areaId) {
                $qb->where('area_id', $areaId);
            }
            if (strpos($keyword, '-') !== false) { // is building
                $keyword = str_replace('g', '高', $keyword);
                $rooms = $qb->where('title', 'like', "{$keyword}%")
                    ->paginate($pageSize);
            } elseif (is_numeric($keyword)) { // is phone
                $rooms = $qb
                    ->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('phone', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('records.company', function ($query) use ($keyword) {
                        $query->where('manager_phone', 'like', "%{$keyword}%")
                            ->orWhere('linkman_phone', 'like', "%{$keyword}%");
                    })
                    ->get();
            } else { // is name or company 
                $rooms = $qb
                    ->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('records.company', function ($query) use ($keyword) {
                        $query->where('company_name', 'like', "%{$keyword}%");
                    })
                    ->get();
            }
            return LivingResource::collection($rooms);
        }
        return LivingResource::collection([]);
    }
}
