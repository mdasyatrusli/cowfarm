<?php

namespace App\Policies;

use App\Models\Breed;
use App\Models\User;

class BreedPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All roles can view breeds list (for dropdown selection, etc.)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Breed $breed): bool
    {
        // All roles can view a breed
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only super_admin can create breeds
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Breed $breed): bool
    {
        // Only super_admin can update breeds
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Breed $breed): bool
    {
        // Only super_admin can delete breeds
        return $user->isSuperAdmin();
    }
}
