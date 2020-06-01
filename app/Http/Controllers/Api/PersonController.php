<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function getOnePerson(Request $request)
    {
        $identify = $request->input('identify', '');

        $selects = [
            'id', 'name', 'identify', 'serial', 'gender', 'contract_start', 'contract_end',
            'education', 'phone', 'department', 'hired_at', 'remark'
        ];
        if ($identify) {
            $person = Person::select($selects)->where('identify', $identify)->first();
            return new PersonResource($person);
        }
        return new PersonResource(null);
    }

    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSize'), 20);
        $name = $request->query('name', '');
        $identify = $request->query('identify', '');
        $phone = $request->query('phone', '');
        // 工号
        $serial = $request->query('serial', '');
        $department = $request->query('department', '');
        $export = $request->query('export', 0);

        $qb = Person::withCount(['records']);
        if ($name) {
            $qb->where('name', 'like', "%{$name}%");
        }
        if ($identify) {
            $qb->where('identify', 'like', "%{$identify}%");
        }
        if ($phone) {
            $qb->where('phone', 'like', "%{$phone}%");
        }
        if ($serial) {
            $qb->where('serial', 'like', "%{$serial}%");
        }
        if ($department) {
            $qb->where('department', 'like', "%{$department}%");
        }

        if ($export) {
            return PersonResource::collection($qb->get());
        }
        return PersonResource::collection($qb->paginate($pageSize));
    }
}
