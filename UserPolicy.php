<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $model)
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine if the given user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model)
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine if the given user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the given user can approve other users.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function approveUser(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can access the admin area.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function accessAdmin(User $user)
    {
        return $user->isAdmin();
    }
}