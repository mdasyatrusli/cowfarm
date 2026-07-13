<?php

namespace App\Policies;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FarmPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Farm $farm): bool
    {
        return $user->isSuperAdmin() || $user->farm_id === $farm->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Farm $farm): Response|bool
    {
        // Super admin can update any farm
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Farm owner can update their own farm
        if ($farm->owner_id === $user->id) {
            return true;
        }

        // Admin Peternakan (admin_farm) can update the farm they are bound to
        // via their own farm_id (they are not necessarily the recorded owner).
        if ($user->isAdminFarm() && $user->farm_id === $farm->id) {
            return true;
        }

        // Staff (user) and other roles are not allowed to update farms
        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat mengubah data peternakan.');
        }

        return Response::deny('Anda tidak memiliki akses untuk mengubah peternakan ini.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Farm $farm): bool
    {
        // Super admin can delete any farm
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Farm owner can delete their own farm
        return $farm->owner_id === $user->id;
    }
}
