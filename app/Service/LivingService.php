<?php

namespace App\Services;

use App\Models\Area;
use App\Models\Room;

class LivingService
{
    /**
     * 分页数
     * 一层17间房，每次支持3层
     */
    protected $pageSize = 3 * 17;

    public function getBaseQueryBuilder()
    {
        return Room::with([
            'area' => function ($query) {
                $query->withTrashed();
            },
            'category' => function ($query) {
                $query->withTrashed();
            },
            'records',
            'records.person',
            'records.company',
            'records.category',
        ]);
    }

    public function getRoomsBySelect($area, $building, $unit)
    {
        $currentAreaId = Area::where('title', $area)->value('id');
        return $this->getBaseQueryBuilder()->where('area_id', $currentAreaId)
            ->where('building', $building)
            ->where('unit', $unit)
            ->paginate($this->pageSize);
    }

    public function getRoomsBySearch($keyword, $areaId, $categoryId)
    {
        $qb = $this->getBaseQueryBuilder();
        if ($areaId) {
            $qb->where('area_id', $areaId);
        }
        if ($categoryId) {
            $qb->where('category_id', $categoryId);
        }
        if ($keyword) {
            if (strpos($keyword, '-') !== false) { // is building
                $keyword = str_replace(['g', 'h'], ['高', '红'], $keyword);
                $qb->where('title', 'like', "{$keyword}%");
            } elseif (is_numeric($keyword)) { // is phone
                // where 嵌套，类似于： where (whereHas or whereHas)。否则会因为orWhereHas造成查询不准确
                $qb->where(function ($q) use ($keyword) {
                    $q->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('phone', 'like', "%{$keyword}%");
                    })
                        ->orWhereHas('records.company', function ($query) use ($keyword) {
                            $query->where('manager_phone', 'like', "%{$keyword}%")
                                ->orWhere('linkman_phone', 'like', "%{$keyword}%");
                        });
                });
            } else { // is name or company 
                $qb->where(function ($q) use ($keyword) {
                    $q->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                        ->orWhereHas('records.company', function ($query) use ($keyword) {
                            $query->where('company_name', 'like', "%{$keyword}%");
                        });
                });
            }
        }

        return $qb->paginate($this->pageSize);
    }
}
