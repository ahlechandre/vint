<?php

namespace Modules\Project\Policies;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Project\Entities\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
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
    public function create(User $user, Group $group)
    {
        return true;
        // return $user->isManager() || $group->isCoordinatorUser($user);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function update(User $user, Program $program)
    {
        return true;
    }

    /**
     * 
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Group\Entities\Group  $group
     * @return void
     */
    public function updateRequests(User $user, Group $group)
    {
        return $user->isManager() || $group->isCoordinatorUser($user);
    }
}
