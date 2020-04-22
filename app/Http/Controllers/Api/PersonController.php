<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSize'), 20);
        $name = $request->query('name', '');
        $identify = $request->query('identify', '');
        $phone = $request->query('phone', '');
        // 工号
        $serial = $request->query('serial', '');
        $department = $request->query('department', '');

        $qb = Person::query();
        $qb->withCount('records');
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

        return PersonResource::collection($qb->paginate($pageSize));
    }
}
