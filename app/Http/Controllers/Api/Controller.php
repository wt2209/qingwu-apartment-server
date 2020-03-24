<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected function created($message = '创建成功')
    {
        return response()->json(['message' => $message], 201);
    }
}
