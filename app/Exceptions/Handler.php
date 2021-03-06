<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'token非法 [' . $exception->getMessage() . ']',
            ], 401);
        } else if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => $exception->validator->errors()->first(),
            ], 422);
        } else if ($exception instanceof ModelNotFoundException) {
            // 传递的模型id错误
            return response()->json([
                'error' => '参数错误，未找到数据',
            ], 404);
        } else if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => '未找到数据',
            ], 404);
        } else if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'message' => '没有权限',
            ], 403);
        }

        return parent::render($request, $exception);
    }
}
