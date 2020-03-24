<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per-page', 20);
        $title = request()->query('title', '');
        $building = request()->query('building', '');
        $unit = request()->query('unit', '');

        $qb = Room::with('category');
        if ($title) {
            $qb->where('title', 'like', "{$title}%");
        }

        if ($building) {
            $qb->where('building', $building);
        }

        if ($unit) {
            $qb->where('unit', $unit);
        }

        $paginator = $qb->paginate($perPage);

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

    public function update(Request $request, Room $room)
    {
        //
    }

    public function destroy(Room $room)
    {
        //
    }
}
