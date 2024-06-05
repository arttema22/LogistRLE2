<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\SetupIntegration;
use MoonShine\Models\MoonshineUser;

class SetupIntegrationPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function view(MoonshineUser $user, SetupIntegration $item)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function create(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function update(MoonshineUser $user, SetupIntegration $item)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function delete(MoonshineUser $user, SetupIntegration $item)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function restore(MoonshineUser $user, SetupIntegration $item)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function forceDelete(MoonshineUser $user, SetupIntegration $item)
    {
        return $user->moonshine_user_role_id === 1;
    }

    public function massDelete(MoonshineUser $user)
    {
        return $user->moonshine_user_role_id === 1;
    }
}
