<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="公寓管理系统 Api",
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
        return $this->responseJson($message, 201);
    }

    protected function updated($message = '修改成功')
    {
        return $this->responseJson($message, 200);
    }

    protected function deleted($message = '删除成功')
    {
        return $this->responseJson($message, 200);
    }

    protected function ok($message = '操作成功')
    {
        return $this->responseJson($message, 200);
    }

    protected function error($message = '内部错误')
    {
        return $this->responseJson($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function responseJson($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }
}
