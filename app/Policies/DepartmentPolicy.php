<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    /*
    | -----------------------------------------------------------
    |  Determine whether the user can view any department model.
    | -----------------------------------------------------------
    */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('procurement')
            || $user->hasPermissionTo('departments.viewAny');
    }

    /*
    | ---------------------------------------------------------------------
    |  Determine whether the user can view an particular department model.
    | ---------------------------------------------------------------------
    */
    public function view(User $user, Department $department): bool
    {
        $isOwnDepartment = $user->department_id === $department->id;

        return $user->hasRole('procurement')
            || ($user->hasPermissionTo('departments.view') && $isOwnDepartment);
    }

    /*
    | -----------------------------------------------------
    |  Determine whether the user can create a department.
    | -----------------------------------------------------
    */
    public function create(User $user): bool
    {
        return $user->hasRole('procurement')
            && $user->hasPermissionTo('departments.create');
    }

    /*
    | ----------------------------------------------------------------
    |  Determine whether the user can update a particular department.
    | ----------------------------------------------------------------
    */
    public function update(User $user, Department $department): bool
    {
        return $user->hasAnyRole(['procurement', 'accountant'])
            && $user->hasPermissionTo('departments.update');
    }

    /*
    | ----------------------------------------------------------------
    |  Determine whether the user can delete a particular department.
    | ----------------------------------------------------------------
    */
    public function delete(User $user, Department $department): bool
    {
        // No one can delete Procurement and Finance department.
        if (in_array($department->code, config('app.protected_departments', []))) {
            return false;
        }

        return $user->hasRole('procurement')
            && $user->hasPermissionTo('departments.delete');
    }

    /*
    | -----------------------------------------------------------------
    |  Determine whether the user can restore a particular department.
    | -----------------------------------------------------------------
    */
    public function restore(User $user, Department $department): bool
    {
        return false;
    }

    /*
    | ----------------------------------------------------------------------------------
    |  Determine whether the user can permanently delete a particular department model.
    | ----------------------------------------------------------------------------------
    */
    public function forceDelete(User $user, Department $department): bool
    {
        return false;
    }
}
