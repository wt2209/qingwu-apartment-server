<?php

namespace App\Http\Middleware;

use App\Models\Operation;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OperationRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();

        // 不记录路径中包含 system 的操作
        if (!Str::contains($path, 'system')) {
            $operation = [
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'inputs' => $request->all(),
                'path' => $request->path(),
                'url' => $request->fullUrl(),
            ];
            Operation::create($operation);
        }
        return $next($request);
    }
}
