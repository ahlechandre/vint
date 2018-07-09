<?php

namespace Modules\System\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\System\Entities\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * 
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can index.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAbility('roles.index');
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\System\Entities\Role  $post
     * @return bool
     */
    public function view(User $user, Role $role)
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAbility('roles.create');
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\System\Entities\Role  $role
     * @return bool
     */
    public function update(User $user, Role $role)
    {
        return !$role->isAdmin() && $user->hasAbility('roles.update');
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\System\Entities\Role  $role
     * @return bool
     */
    public function delete(User $user, Role $role)
    {
        return !$role->isAdmin() && $user->hasAbility('roles.delete');
    }
}
