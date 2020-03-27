<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $perPage =  $request->query('per-page', config('app.per_page', 20));
        $title =  $request->query('title', '');
        $building = $request->query('building', '');
        $unit =  $request->query('unit', '');
        $status =  $request->query('status', Room::STATUS_ALL);
        $export =  $request->query('export', 0);

        $qb = Room::with('category');
        if ($title) {
            $qb->where('title', 'like', "{$title}%");
        }

        if ($building) {
            $qb->where('building', 'like', "{$building}%");
        }

        if ($unit) {
            $qb->where('unit', $unit);
        }

        // 需要导出数据
        if ($export) {
            switch ($status) {
                case Room::STATUS_DELETED:
                    $collection = $qb->onlyTrashed()->get();
                    break;
                case Room::STATUS_USING:
                    $collection = $qb->get();
                    break;
                default: // all
                    $collection = $qb->withTrashed()->get();
                    break;
            }
            return RoomResource::collection($collection);
        }

        switch ($status) {
            case Room::STATUS_DELETED:
                $paginator = $qb->onlyTrashed()->paginate($perPage);
                break;
            case Room::STATUS_USING:
                $paginator = $qb->paginate($perPage);
                break;
            default: // all
                $paginator = $qb->withTrashed()->paginate($perPage);
                break;
        }

        return RoomResource::collection($paginator);
    }

    public function store(CreateRoomRequest $request)
    {
        Room::create($request->all());
        return $this->created();
    }

    public function show($id)
    {
        $room = Room::with(['category', 'area'])->find($id);
        return new RoomResource($room);
    }

    public function update(UpdateRoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->fill($request->all());
        $room->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return $this->deleted();
    }
}
