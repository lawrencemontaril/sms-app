<?php

namespace App\Policies;

use App\Models\SupplyRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupplyRequestPolicy
{
    /*
    | -----------------------------------------------------------
    |  Determine whether the user can view any department model.
    | -----------------------------------------------------------
    */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /*
    | ---------------------------------------------------------------------
    |  Determine whether the user can view an particular department model.
    | ---------------------------------------------------------------------
    */
    public function view(User $user, SupplyRequest $supplyRequest): bool
    {
        return $user->hasRole('procurement')
            || $user->supplyRequests()->where('id', $supplyRequest->id)->exists();
    }

    /*
    | -----------------------------------------------------
    |  Determine whether the user can create a department.
    | -----------------------------------------------------
    */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['faculty', 'accounting']);
    }

    /*
    | ----------------------------------------------------------------
    |  Determine whether the user can update a particular department.
    | ----------------------------------------------------------------
    */
    public function update(User $user, SupplyRequest $supplyRequest): bool
    {
        return $user->hasAnyRole(['procurement', 'faculty', 'accounting']);
    }

    /*
    | ----------------------------------------------------------------
    |  Determine whether the user can delete a particular department.
    | ----------------------------------------------------------------
    */
    public function delete(User $user, SupplyRequest $supplyRequest): bool
    {
        return false;
    }

    /*
    | -----------------------------------------------------------------
    |  Determine whether the user can restore a particular department.
    | -----------------------------------------------------------------
    */
    public function restore(User $user, SupplyRequest $supplyRequest): bool
    {
        return false;
    }

    /*
    | ----------------------------------------------------------------------------------
    |  Determine whether the user can permanently delete a particular department model.
    | ----------------------------------------------------------------------------------
    */
    public function forceDelete(User $user, SupplyRequest $supplyRequest): bool
    {
        return false;
    }
}
