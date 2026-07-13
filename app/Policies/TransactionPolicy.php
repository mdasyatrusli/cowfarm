<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any transactions.
     * Only admin_farm and super_admin can see the Transactions menu.
     */
    public function viewAny(User $user): Response
    {
        return $user->isSuperAdmin() || $user->isAdminFarm()
            ? Response::allow()
            : Response::deny('Hanya Super Admin atau Admin Peternakan yang dapat mengakses menu Transaksi.');
    }

    /**
     * Determine whether the user can view the transaction.
     */
    public function view(User $user, Transaction $transaction): Response
    {
        return $user->isSuperAdmin() || $user->farm_id === $transaction->farm_id
            ? Response::allow()
            : Response::deny('Anda hanya dapat melihat transaksi dari peternakan Anda sendiri.');
    }

    /**
     * Determine whether the user can create transactions.
     * ONLY admin_farm can create transactions (financial data is sensitive).
     * Super admin is NOT allowed (no farm_id), and regular users are NOT allowed.
     */
    public function create(User $user): Response
    {
        return $user->isAdminFarm() && ! is_null($user->farm_id)
            ? Response::allow()
            : Response::deny('Hanya Admin Peternakan yang dapat menambah transaksi.');
    }

    /**
     * Determine whether the user can update the transaction.
     * ONLY admin_farm from the same farm can update (financial data is sensitive).
     * Super admin and regular users are NOT allowed.
     */
    public function update(User $user, Transaction $transaction): Response
    {
        return $user->isAdminFarm() && $user->farm_id && $user->farm_id === $transaction->farm_id
            ? Response::allow()
            : Response::deny('Hanya Admin Peternakan dari peternakan yang sama yang dapat mengubah transaksi ini.');
    }

    /**
     * Determine whether the user can delete the transaction.
     * Super admin may delete for maintenance; admin_farm of the same farm
     * may also delete.
     */
    public function delete(User $user, Transaction $transaction): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return $user->isAdminFarm() && $user->farm_id === $transaction->farm_id
            ? Response::allow()
            : Response::deny('Hanya Super Admin atau Admin Peternakan dari peternakan yang sama yang dapat menghapus transaksi ini.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return false;
    }
}
