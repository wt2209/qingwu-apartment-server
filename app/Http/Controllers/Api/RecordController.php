<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RecordResource;
use App\Models\Company;
use App\Models\Person;
use App\Models\Record;
use App\Models\Room;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSize', 20));
        $areaId = $request->query('area_id', 0);
        $categoryId = $request->query('category_id', 0);
        $room = $request->query('room', '');
        $name = $request->query('name', '');
        $identify = $request->query('identify', '');
        $companyName = $request->query('company_name', '');
        $status = $request->query('status', '');
        $export = $request->query('export', 0);

        $qb = Record::with([
            'person',
            'room' => function ($query) {
                $query->withTrashed();
            },
            'category' => function ($query) {
                $query->withTrashed();
            },
            'area' => function ($query) {
                $query->withTrashed();
            },
            'company',
            'toRoom' => function ($query) {
                $query->withTrashed();
            },
        ])
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

        if ($name || $identify) {
            $personQb = Person::query();
            if ($name) {
                $personQb->where('name', 'like', "%{$name}%");
            }
            if ($identify) {
                $personQb->where('identify', 'like', "%{$identify}%");
            }
            $personIds = $personQb->pluck('id')->toArray();
            $qb->whereIn('person_id', $personIds);
        }

        if ($room) {
            $roomIds = Room::where('title', 'like', "%{$name}%")->pluck('id')->toArray();
            $qb->whereIn('room_id', $roomIds);
        }

        if ($companyName) {
            $companyIds = Company::where('company_name', 'like', "%{$companyName}%")->pluck('id')->toArray();
            $qb->whereIn('company_id', $companyIds);
        }

        if ($export) {
            return RecordResource::collection($qb->get());
        }
        return RecordResource::collection($qb->paginate($pageSize));
    }
}
