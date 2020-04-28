<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSiez', 20));
        $areaId = $request->query('area_id', 0);
        $categoryId = $request->query('category_id', 0);
        $status = $request->query('status', '');
        $qb = Record::with(['person', 'room', 'category', 'area', 'company', 'toRoom'])
            ->withTrashed();
        if ($areaId) {
            $qb->where('area_id', $areaId);
        }
        if ($categoryId) {
            $qb->where('category_id', $categoryId);
        }
        if ($status) {
            $qb->where('status', $status);
        }

        return RecordResource::collection($qb->paginate($pageSize));
    }
}
