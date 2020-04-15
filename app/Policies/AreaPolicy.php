<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 定义用户能不能操作现在的资源（area_id）
 */
class AreaPolicy
{
    use HandlesAuthorization;

    /**
     * 超级管理员所有方法完全放行
     */
    public function before($user, $ability)
    {
        return $user->username === config('app.super_admin');
    }
    /**
     * 用户是否可以创建区域（area）
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * 用户是否可以修改区域（area）
     */
    public function update(User $user)
    {
        return false;
    }

    /**
     * 用户是否可以删除区域（area）
     */
    public function delete(User $user)
    {
        return false;
    }

    /**
     * 用户是否可以删除区域（area）
     */
    public function restore(User $user)
    {
        return false;
    }
}
