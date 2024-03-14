<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\DirPetrolStation;
use MoonShine\Models\MoonshineUser;

class DirPetrolStationPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user)
    {
        return true;
    }

    public function view(MoonshineUser $user, DirPetrolStation $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function create(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function update(MoonshineUser $user, DirPetrolStation $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function delete(MoonshineUser $user, DirPetrolStation $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function restore(MoonshineUser $user, DirPetrolStation $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function forceDelete(MoonshineUser $user, DirPetrolStation $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function massDelete(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id != 3;
    }
}
