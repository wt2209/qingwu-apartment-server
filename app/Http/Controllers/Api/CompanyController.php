<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getAllCompanies()
    {
        return CompanyResource::collection(Company::select(['id', 'company_name'])->get());
    }

    public function getOneCompany(Request $request)
    {
        $name = $request->input('name', '');

        $selects = [
            'company_name', 'manager', 'manager_phone', 'linkman', 'linkman_phone', 'remark'
        ];
        if ($name) {
            $company = Company::select($selects)->where('company_name', $name)->first();
            return new CompanyResource($company);
        }
        return new CompanyResource(null);
    }

    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSiez', 20));
        $export = $request->query('export', 0);

        $qb = Company::query();
        $qb->withCount('records');
        if ($export) {
            return CompanyResource::collection($qb->get());
        }
        return CompanyResource::collection($qb->paginate($pageSize));
    }
}
