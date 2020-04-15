<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Resources\AreaResource;

class AreaController extends Controller
{
    public function getAllAreas()
    {
        return AreaResource::collection(Area::all());
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', config('app.per_page', 20));
        $status =  $request->query('status', Area::STATUS_ALL);

        $qb = Area::query();
        switch ($status) {
            case Area::STATUS_DELETED:
                $qb->onlyTrashed();
                break;
            case Area::STATUS_ALL:
                $qb->withTrashed();
                break;
        }
        return AreaResource::collection($qb->paginate($perPage));
    }

    public function store(AreaRequest $request)
    {
        $this->authorize('create', Area::class);
        Area::create($request->all());
        return $this->created();
    }

    public function show($id)
    {
        $area = Area::find($id);
        return new AreaResource($area);
    }

    public function update(AreaRequest $request, $id)
    {
        $this->authorize('update', Area::class);
        $area = Area::findOrFail($id);
        $area->fill($request->all());
        $area->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $this->authorize('delete', Area::class);
        $area = Area::findOrFail($id);
        $area->delete();
        return $this->deleted();
    }

    public function restore($id)
    {
        $this->authorize('restore', Area::class);
        $area = Area::onlyTrashed()->findOrFail($id);
        $area->restore();
        return $this->ok();
    }
}
