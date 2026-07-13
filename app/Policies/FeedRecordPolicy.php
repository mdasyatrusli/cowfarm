<?php

namespace App\Policies;

use App\Models\FeedRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FeedRecordPolicy
{
    /**
     * Determine whether the user can view any feed records.
     * For non-super-admin, BelongsToTenant scope handles filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the feed record.
     */
    public function view(User $user, FeedRecord $feedRecord): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $feedRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat catatan pakan dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create feed records.
     * Super admin is NOT allowed — farm_id is NOT NULL in the DB.
     * Only farm-bound roles (admin_farm, user) with a valid farm_id may create.
     */
    public function create(User $user): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat menambah catatan pakan.');
        }

        return ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Anda harus terdaftar di peternakan untuk menambah catatan pakan.');
    }

    /**
     * Determine whether the user can update the feed record.
     * Super admin is NOT allowed (consistent with other modules). Only
     * Admin Peternakan (admin_farm) of the same farm may update.
     * Staff (user) is explicitly denied.
     */
    public function update(User $user, FeedRecord $feedRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat mengedit catatan pakan.');
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat mengedit catatan pakan.');
        }

        return $user->isAdminFarm() && $user->farm_id === $feedRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk mengubah catatan pakan ini.');
    }

    /**
     * Determine whether the user can delete the feed record.
     * Super admin may delete for maintenance; admin_farm of the same farm may also delete.
     */
    public function delete(User $user, FeedRecord $feedRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat menghapus catatan pakan.');
        }

        return $user->isAdminFarm() && $user->farm_id === $feedRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk menghapus catatan pakan ini.');
    }
}
