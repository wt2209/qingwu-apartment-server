<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected function created($message = '创建成功')
    {
        return response()->json(['message' => $message], 201);
    }

    protected function updated($message = '修改成功')
    {
        return response()->json(['message' => $message], 200);
    }

    protected function deleted($message = '删除成功')
    {
        return response()->json(['message' => $message], 200);
    }
}
