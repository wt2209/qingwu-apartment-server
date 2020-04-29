<?php

namespace App\Scopes;

use App\Models\Area;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AreasScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }
        // 超级管理员可以操作所有区域
        if ($user->username === config('app.super_admin')) {
            return;
        }
        $areas = explode(',', $user->areas);

        if ($model instanceof Area) {
            $builder->whereIn('id', $areas);
        } else {
            $builder->whereIn('area_id', $areas);
        }
    }
}
