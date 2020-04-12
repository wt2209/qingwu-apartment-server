<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $perPage =  $request->query('per_page', config('app.per_page', 20));
        $areas = $request->query('areas', []);
        $categories = $request->query('categories', []);
        $title =  $request->query('title', '');
        $building = $request->query('building', '');
        $unit =  $request->query('unit', '');
        $status =  $request->query('status', Room::STATUS_ALL);
        $export =  $request->query('export', 0);

        $qb = Room::with(['category', 'area']);
        if ($areas) {
            $qb->whereIn('area_id', $areas);
        }
        if ($categories) {
            $qb->whereIn('category_id', $categories);
        }
        if ($title) {
            $qb->where('title', 'like', "{$title}%");
        }
        if ($building) {
            $qb->where('building', 'like', "{$building}%");
        }
        if ($unit) {
            $qb->where('unit', $unit);
        }
        switch ($status) {
            case Room::STATUS_DELETED:
                $qb->onlyTrashed();
                break;
            case Room::STATUS_ALL:
                $qb->withTrashed();
                break;
        }
        // 需要导出数据
        if ($export) {
            return RoomResource::collection($qb->get());
        }
        return RoomResource::collection($qb->paginate($perPage));
    }

    public function store(RoomRequest $request)
    {
        // 验证本房间所属区域是否允许此用户添加
        $this->authorize('create', [Room::class, $request->input('area_id')]);
        Room::create($request->all());
        return $this->created();
    }

    public function show($id)
    {
        $room = Room::with(['category', 'area'])->find($id);
        return new RoomResource($room);
    }

    public function update(RoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        // 验证本房间所属区域及要修改为的区域是否允许此用户修改
        $this->authorize('update', [Room::class, $room->area_id, $request->area_id]);
        $room->fill($request->all());
        $room->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        // 验证本房间所属区域是否允许此用户删除
        $this->authorize('delete', [Room::class, $room->area_id]);
        $room->delete();
        return $this->deleted();
    }
}
