<?php

namespace App\Policies;

use App\Models\Cow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CowPolicy
{
    /**
     * Determine whether the user can view any cows.
     * For non-super-admin, the BelongsToTenant global scope handles filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the cow.
     */
    public function view(User $user, Cow $cow): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $cow->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat data sapi dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create cows.
     * Super admin is NOT allowed — farm_id is NOT NULL in the DB, and
     * super admin has no farm_id. Only farm-bound roles (admin_farm, user)
     * with a valid farm_id may create.
     */
    public function create(User $user): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat menambah data sapi.');
        }

        return ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Anda harus terdaftar di peternakan untuk menambah data sapi.');
    }

    /**
     * Determine whether the user can update the cow.
     * Super admin may NOT update (no farm_id bound). Only farm-bound
     * users from the same farm may update.
     */
    public function update(User $user, Cow $cow): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat mengedit data sapi.');
        }

        return $user->farm_id && $user->farm_id === $cow->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk mengubah data sapi ini.');
    }

    /**
     * Determine whether the user can delete the cow.
     * Super admin may delete for maintenance; admin_farm of the same farm
     * may also delete.
     */
    public function delete(User $user, Cow $cow): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat menghapus data sapi.');
        }

        return $user->isAdminFarm() && $user->farm_id === $cow->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk menghapus sapi ini.');
    }
}
