<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeeTypePolicy
{
    use HandlesAuthorization;

    /**
     * 超级管理员所有方法完全放行
     */
    public function before($user, $ability)
    {
        return $user->username === config('app.super_admin');
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }

    public function restore(User $user)
    {
        return false;
    }
}
