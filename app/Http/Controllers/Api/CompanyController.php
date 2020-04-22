<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSiez', 20));
        $qb = Company::query();
        $qb->withCount('records');

        return CompanyResource::collection($qb->paginate($pageSize));
    }
}
