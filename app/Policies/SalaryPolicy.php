<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Salary;
use MoonShine\Models\MoonshineUser;

class SalaryPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user)
    {
        return true;
    }

    public function view(MoonshineUser $user, Salary $item)
    {
        return $user->moonshine_user_role_id != 3 or $user->id == $item->driver_id;
    }

    public function create(MoonshineUser $user)
    {
        return true;
    }

    public function update(MoonshineUser $user, Salary $item)
    {
        return $user->moonshine_user_role_id != 3 or $user->id == $item->driver_id;
    }

    public function delete(MoonshineUser $user, Salary $item)
    {
        return $user->moonshine_user_role_id != 3 or $user->id == $item->driver_id;
    }

    public function restore(MoonshineUser $user, Salary $item)
    {
        return true;
    }

    public function forceDelete(MoonshineUser $user, Salary $item)
    {
        return true;
    }

    public function massDelete(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id != 3;
    }
}
