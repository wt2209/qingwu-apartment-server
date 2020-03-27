<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 定义用户能不能操作现在的资源（area_id）
 */
class AreasPolicy
{
    use HandlesAuthorization;

    /**
     * 创建资源（room,person,company,record,category）时验证用户是否可以创建
     * @return boolean
     */
    public function areaCreate(User $user, int $areaId)
    {
        return in_array($areaId, explode(',', $user->areas));
    }

    /**
     * 修改资源（room,person,company,record,category）时验证用户是否可以修改
     * @return boolean
     */
    public function areaUpdate(User $user, int $areaId, int $toAreaId)
    {
        return in_array($areaId, explode(',', $user->areas))
            && in_array($toAreaId, explode(',', $user->areas));
    }

    /**
     * 删除资源（room,person,company,record,category）时验证用户是否可以删除
     * @return boolean
     */
    public function areaDelete(User $user, int $areaId)
    {
        return in_array($areaId, explode(',', $user->areas));
    }
}
