<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="公寓管理系统接口文档",
 *      @OA\Contact(
 *          email="wt2209@126.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
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
