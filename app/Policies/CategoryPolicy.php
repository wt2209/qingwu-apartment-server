<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy extends AbstractCommonPolicy
{
    public function restore(User $user)
    {
        return true;
    }
}
