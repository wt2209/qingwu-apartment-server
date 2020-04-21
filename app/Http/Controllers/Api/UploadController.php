<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->extension();
        $permitted = ['xls', 'xlsx', 'doc', 'docx', 'pdf', 'txt', 'jpg', 'jpeg', 'png', 'gif'];
        if (in_array($extension, $permitted)) {
            $path = $file->store('upload');
            if ($path) {
                return response()->json(['path' => $path]);
            } else {
                return response()->json(['error' => '上传失败'], 500);
            }
        }
        return response()->json(['error' => '文件类型错误'], 422);
    }

    public function remove(Request $request)
    {
        $path = $request->input('path', '');
        if ($path) {
            $success = Storage::delete([$path]);
            if ($success) {
                return response()->json(['status' => 'ok']);
            }
        }
        return response()->json(['error' => '文件未找到'], 404);
    }
}
