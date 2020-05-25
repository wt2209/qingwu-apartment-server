<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $qb = Bill::with(['area']);

        $bills = $qb->paginate();
        return BillResource::collection($bills);
    }
}
