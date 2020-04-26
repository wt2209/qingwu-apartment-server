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
        $qb = Record::with(['person', 'room', 'category', 'area', 'company', 'toRoom'])
            ->withTrashed();

        return RecordResource::collection($qb->paginate($pageSize));
    }
}
