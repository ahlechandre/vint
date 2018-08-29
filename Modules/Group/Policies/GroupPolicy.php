<?php

namespace Modules\Group\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;

class GroupPolicy
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
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isManager();
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Group\Entities\Group  $group
     * @return bool
     */
    public function update(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function createCoordinators(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function deleteCoordinators(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function updateCoordinators(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }
    
    /**
     *
     * @param \Modules\User\Entities\User $user
     * @param \Modules\Group\Entities\Group $group
     * @return bool
     */
    public function updateMemberRequests(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }
}
