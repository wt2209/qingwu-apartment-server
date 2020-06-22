<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize', config('app.pageSize'), 20);
        $user = $request->query('user', '');
        $ip = $request->query('ip', '');
        $method = $request->query('method', '');
        $path = $request->query('path', '');

        $qb = Operation::with('user');

        if ($user) {
            $user = User::where('name', $user)->first();
            $qb->where('user_id', $user->id);
        }
        if ($ip) {
            $qb->where('ip', $ip);
        }
        if ($method) {
            $qb->where('method', $method);
        }
        if ($path) {
            $qb->where('path', $path);
        }

        return OperationResource::collection($qb->orderBy('id', 'desc')->paginate($pageSize));
    }
}
