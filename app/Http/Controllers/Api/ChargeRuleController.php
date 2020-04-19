<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ChargeRuleResource;
use App\Models\ChargeRule;
use Illuminate\Http\Request;

class ChargeRuleController extends Controller
{
    public function getAllChargeRules(Request $request)
    {
        $type = $request->query('type', '');
        $qb = ChargeRule::query();
        if ($type) {
            $qb->where('type', $type);
        }
        return ChargeRuleResource::collection($qb->get());
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', config('app.per_page', 20));
        $status =  $request->query('status', ChargeRule::STATUS_ALL);
        $type = $request->query('type', '');
        $way = $request->query('way', '');

        $qb = ChargeRule::query();
        if ($type) {
            $qb->where('type', $type);
        }
        if ($way) {
            $qb->where('way', $way);
        }
        switch ($status) {
            case ChargeRule::STATUS_DELETED:
                $qb->onlyTrashed();
                break;
            case ChargeRule::STATUS_ALL:
                $qb->withTrashed();
                break;
        }
        return ChargeRuleResource::collection($qb->paginate($perPage));
    }

    public function store(Request $request)
    {
        $this->authorize('create', ChargeRule::class);
        ChargeRule::create($request->all());
        return $this->created();
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', ChargeRule::class);
        $area = ChargeRule::findOrFail($id);
        $area->fill($request->all());
        $area->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $this->authorize('delete', ChargeRule::class);
        $rule = ChargeRule::findOrFail($id);
        $rule->delete();
        return $this->deleted();
    }

    public function restore($id)
    {
        $this->authorize('restore', ChargeRule::class);
        $rule = ChargeRule::onlyTrashed()->findOrFail($id);
        $rule->restore();
        return $this->ok();
    }
}
