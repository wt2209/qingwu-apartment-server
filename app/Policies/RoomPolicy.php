<?php

namespace App\Policies;

use App\Models\User;

class RoomPolicy extends AbstractCommonPolicy
{
    public function restore(User $user)
    {
        return true;
    }
}
