<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CompanyRenameResource;
use App\Models\Company;
use App\Models\CompanyRename;
use Illuminate\Http\Request;

class CompanyRenameController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSiez', 20));
        $companyName = $request->query('company_name', '');

        $qb = CompanyRename::with(['company']);
        if ($companyName) {
            $ids = Company::where('company_name', 'like', "%{$companyName}%")->pluck('id');
            $qb->whereIn('company_id', $ids)
                ->orWhere('old_company_name', 'like', "%{$companyName}%")
                ->orWhere('new_company_name', 'like', "%{$companyName}%");
        }

        return CompanyRenameResource::collection($qb->paginate($pageSize));
    }
}
