<?php

namespace App\Policies;

use App\Models\FeedStockLog;
use App\Models\User;

class FeedStockLogPolicy
{
    /**
     * Determine whether the user can view any feed stock logs.
     * BelongsToTenant scope handles the filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the feed stock log.
     */
    public function view(User $user, FeedStockLog $feedStockLog): bool
    {
        return $user->isSuperAdmin() || $user->farm_id === $feedStockLog->farm_id;
    }

    /**
     * Determine whether the user can create feed stock logs.
     * Super admin is NOT allowed (no farm_id).
     * Only farm-bound roles with a valid farm_id may create.
     */
    public function create(User $user): bool
    {
        return ! $user->isSuperAdmin() && ! is_null($user->farm_id);
    }

    /**
     * Determine whether the user can update the feed stock log.
     */
    public function update(User $user, FeedStockLog $feedStockLog): bool
    {
        return ! $user->isSuperAdmin() && $user->farm_id && $user->farm_id === $feedStockLog->farm_id;
    }

    /**
     * Determine whether the user can delete the feed stock log.
     */
    public function delete(User $user, FeedStockLog $feedStockLog): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isAdminFarm() && $user->farm_id === $feedStockLog->farm_id;
    }
}
