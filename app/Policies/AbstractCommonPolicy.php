<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class AbstractCommonPolicy
{
    use HandlesAuthorization;
    /**
     * 超级管理员完全放行
     */
    public function before($user, $ability)
    {
        return $user->username === config('app.super_admin');
    }

    /**
     * 创建资源（room,person,company,record,category）时验证用户是否可以创建
     * @return boolean
     */
    public function create(User $user, int $areaId)
    {
        return in_array($areaId, explode(',', $user->areas));
    }

    /**
     * 修改资源（room,person,company,record,category）时验证用户是否可以修改
     * @return boolean
     */
    public function update(User $user, int $areaId, int $toAreaId)
    {
        return in_array($areaId, explode(',', $user->areas))
            && in_array($toAreaId, explode(',', $user->areas));
    }

    /**
     * 删除资源（room,person,company,record,category）时验证用户是否可以删除
     * @return boolean
     */
    public function delete(User $user, int $areaId)
    {
        return in_array($areaId, explode(',', $user->areas));
    }
}
