<?php

declare(strict_types=1);

namespace App\Policies;

use MoonShine\Models\MoonshineUser;
use App\Models\Dir\DirPetrolStationBrand;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirPetrolStationBrandPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user)
    {
        return true;
    }

    public function view(MoonshineUser $user, DirPetrolStationBrand $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function create(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function update(MoonshineUser $user, DirPetrolStationBrand $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function delete(MoonshineUser $user, DirPetrolStationBrand $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function restore(MoonshineUser $user, DirPetrolStationBrand $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function forceDelete(MoonshineUser $user, DirPetrolStationBrand $item)
    {
        return $user->moonshine_user_role_id != 3;
    }

    public function massDelete(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id != 3;
    }
}
