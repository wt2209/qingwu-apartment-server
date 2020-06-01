<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RenewResource;
use App\Models\Renew;
use Illuminate\Http\Request;

class RenewController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSize'), 20);
        $type = $request->query('record-type', '');
        $room = $request->query('record-room-title', '');
        $name = $request->query('record-person-name', '');
        $companyName = $request->query('record-company-company_name', '');
        $export = $request->query('export', 0);

        $qb = Renew::with([
            'record' => function ($query) {
                $query->withTrashed();
            },
            'record.person',
            'record.company',
            'record.room' => function ($query) {
                $query->withTrashed();
            },
        ]);
        if ($name) {
            $qb->whereHas('record.person', function ($query) use ($name) {
                $query->where('name', 'like', "{$name}%");
            });
        }
        if ($companyName) {
            $qb->whereHas('record.company', function ($query) use ($companyName) {
                $query->where('company_name', 'like', "%{$companyName}%");
            });
        }
        if ($type) {
            $qb->whereHas('record', function ($query) use ($type) {
                $query->where('type', $type);
            });
        }
        if ($room) {
            $qb->whereHas('record.room', function ($query) use ($room) {
                $query->where('title', 'like', "{$room}%");
            });
        }

        if ($export) {
            return RenewResource::collection($qb->get());
        }
        return RenewResource::collection($qb->paginate($pageSize));
    }
}
