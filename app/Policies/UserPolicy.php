<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /*
    | -----------------------------------------------------
    |  Determine whether the user can view any user model.
    | -----------------------------------------------------
    */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('procurement')
            || $user->hasPermissionTo('users.viewAny');
    }

    /*
    | ---------------------------------------------------------------
    |  Determine whether the user can view an particular user model.
    | ---------------------------------------------------------------
    */
    public function view(User $user, User $model): bool
    {
        $isOwnUser = $user->id === $model->id;

        return $user->hasRole('procurement')
            || ($user->hasPermissionTo('users.viewAny') && $isOwnUser);
    }

    /*
    | -----------------------------------------------
    |  Determine whether the user can create a user.
    | -----------------------------------------------
    */
    public function create(User $user): bool
    {
        return $user->hasRole('procurement')
            || $user->hasPermissionTo('users.create');
    }

    /*
    | ----------------------------------------------------------
    |  Determine whether the user can update a particular user.
    | ----------------------------------------------------------
    */
    public function update(User $user, User $model): bool
    {
        $isOwnUser = $user->id === $model->id;

        return $user->hasRole('procurement')
            || ($user->hasPermissionTo('users.update') && $isOwnUser);
    }

    /*
    | ----------------------------------------------------------
    |  Determine whether the user can delete a particular user.
    | ----------------------------------------------------------
    */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('procurement')
            || $user->hasPermissionTo('users.delete');
    }

    /*
    | -----------------------------------------------------------
    |  Determine whether the user can restore a particular user.
    | -----------------------------------------------------------
    */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /*
    | ----------------------------------------------------------------------------
    |  Determine whether the user can permanently delete a particular user model.
    | ----------------------------------------------------------------------------
    */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
