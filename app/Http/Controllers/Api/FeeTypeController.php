<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FeeTypeRequest;
use App\Http\Resources\FeeTypeResource;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function getAllFeeTypes()
    {
        return FeeTypeResource::collection(FeeType::all());
    }

    public function index(Request $request)
    {
        $perPage = $request->query('pageSize', config('app.pageSize', 20));
        $title = $request->query('title', '');
        $turnIn = $request->query('turn_in', null);
        $status =  $request->query('status', FeeType::STATUS_ALL);
        $export = $request->query('export', 0);

        $qb = FeeType::query();
        if ($title) {
            $qb->where('title', 'like', "{$title}%");
        }
        if ($turnIn !== null) {
            $qb->where('turn_in', $turnIn);
        }
        switch ($status) {
            case FeeType::STATUS_DELETED:
                $qb->onlyTrashed();
                break;
            case FeeType::STATUS_ALL:
                $qb->withTrashed();
                break;
        }
        if ($export) {
            return FeeTypeResource::collection($qb->get());
        }
        return FeeTypeResource::collection($qb->paginate($perPage));
    }

    public function store(FeeTypeRequest $request)
    {
        $this->authorize('create', FeeType::class);
        FeeType::create($request->all());
        return $this->created();
    }

    public function update(FeeTypeRequest $request, $id)
    {
        $this->authorize('update', FeeType::class);
        $type = FeeType::findOrFail($id);
        $type->fill($request->all());
        $type->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $this->authorize('delete', FeeType::class);
        $feeType = FeeType::findOrFail($id);
        $feeType->delete();
        return $this->deleted();
    }

    public function restore($id)
    {
        $this->authorize('restore', FeeType::class);
        $feeType = FeeType::onlyTrashed()->findOrFail($id);
        $feeType->restore();
        return $this->ok();
    }
}
