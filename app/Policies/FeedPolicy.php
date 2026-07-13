<?php

namespace App\Policies;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FeedPolicy
{
    /**
     * Determine whether the user can view any feeds.
     * For non-super-admin, BelongsToTenant scope handles filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the feed.
     */
    public function view(User $user, Feed $feed): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $feed->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat data pakan dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create feeds.
     * Super admin is NOT allowed — farm_id is NOT NULL in the DB.
     * Only farm-bound roles (admin_farm, user) with a valid farm_id may create.
     */
    public function create(User $user): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat menambah data pakan.');
        }

        return ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Anda harus terdaftar di peternakan untuk menambah data pakan.');
    }

    /**
     * Determine whether the user can update the feed.
     */
    public function update(User $user, Feed $feed): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat mengedit data pakan.');
        }

        return $user->farm_id && $user->farm_id === $feed->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk mengubah data pakan ini.');
    }

    /**
     * Determine whether the user can delete the feed.
     */
    public function delete(User $user, Feed $feed): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat menghapus data pakan.');
        }

        return $user->isAdminFarm() && $user->farm_id === $feed->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk menghapus data pakan ini.');
    }
}
