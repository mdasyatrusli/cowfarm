<?php

namespace App\Policies;

use App\Models\HealthRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HealthRecordPolicy
{
    /**
     * Determine whether the user can view any health records.
     * For non-super-admin, BelongsToTenant scope handles filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the health record.
     */
    public function view(User $user, HealthRecord $healthRecord): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $healthRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat catatan kesehatan dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create health records.
     * Super admin is NOT allowed — farm_id is NOT NULL in the DB.
     * Only farm-bound roles (admin_farm, user) with a valid farm_id may create.
     */
    public function create(User $user): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat menambah catatan kesehatan.');
        }

        return ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Anda harus terdaftar di peternakan untuk menambah catatan kesehatan.');
    }

    /**
     * Determine whether the user can update the health record.
     */
    public function update(User $user, HealthRecord $healthRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat mengedit catatan kesehatan.');
        }

        return $user->farm_id && $user->farm_id === $healthRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk mengubah catatan kesehatan ini.');
    }

    /**
     * Determine whether the user can delete the health record.
     */
    public function delete(User $user, HealthRecord $healthRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat menghapus catatan kesehatan.');
        }

        return $user->isAdminFarm() && $user->farm_id === $healthRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk menghapus catatan kesehatan ini.');
    }
}
