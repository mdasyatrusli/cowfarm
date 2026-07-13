<?php

namespace App\Policies;

use App\Models\MilkRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MilkRecordPolicy
{
    /**
     * Determine whether the user can view any milk records.
     * For non-super-admin, BelongsToTenant scope handles filtering.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the milk record.
     */
    public function view(User $user, MilkRecord $milkRecord): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $milkRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat catatan produksi susu dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create milk records.
     * Super admin is NOT allowed — farm_id is NOT NULL in the DB.
     * Only farm-bound roles (admin_farm, user) with a valid farm_id may create.
     */
    public function create(User $user): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat menambah catatan produksi susu.');
        }

        return ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Anda harus terdaftar di peternakan untuk menambah catatan produksi susu.');
    }

    /**
     * Determine whether the user can update the milk record.
     */
    public function update(User $user, MilkRecord $milkRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::deny('Super Admin tidak dapat mengedit catatan produksi susu.');
        }

        return $user->farm_id && $user->farm_id === $milkRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk mengubah catatan produksi susu ini.');
    }

    /**
     * Determine whether the user can delete the milk record.
     */
    public function delete(User $user, MilkRecord $milkRecord): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isUser()) {
            return Response::deny('Staff tidak dapat menghapus catatan produksi susu.');
        }

        return $user->isAdminFarm() && $user->farm_id === $milkRecord->farm_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki akses untuk menghapus catatan produksi susu ini.');
    }
}
