<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Refilling;
use MoonShine\Models\MoonshineUser;

class RefillingPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user)
    {
        return true;
    }

    public function view(MoonshineUser $user, Refilling $item)
    {
        return true;
    }

    public function create(MoonshineUser $user)
    {
        return true;
    }

    public function update(MoonshineUser $user, Refilling $item)
    {
        return $item->integration_id == null;
    }

    public function delete(MoonshineUser $user, Refilling $item)
    {
        return $item->integration_id == null;
    }

    public function restore(MoonshineUser $user, Refilling $item)
    {
        return true;
    }

    public function forceDelete(MoonshineUser $user, Refilling $item)
    {
        return true;
    }

    public function massDelete(MoonshineUser $user)
    {
        return false;
    }
}
