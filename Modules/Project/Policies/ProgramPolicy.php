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
        return $user->isManager() ||
            $group->hasCoordinatorUser($user) ||
            $group->allowsForUser('programs.create', $user);
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
        $group = $program->group;

        if ($user->isManager() || $group->hasCoordinatorUser($user)) {
            return true;
        }
        $canUpdate = $group->allowsForUser('programs.update', $user);

        if (!$canUpdate) {
            return false;
        }
        $isRelated = $program->user_id === $user->id ||
            $program->coordinator_id === $user->id;

        return $isRelated;
    }

    /**
     *
     * @param \Modules\User\Entities\User $user
     * @param \Modules\Project\Entities\Program $program
     * @return bool
     */
    public function delete(User $user, Program $program)
    {
        return $user->isManager();
    }

    /**
     * 
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Group\Entities\Group  $group
     * @return void
     */
    public function updateRequests(User $user, Group $group)
    {
        return $user->isManager() ||
            $group->hasCoordinatorUser($user) ||
            $group->allowsForUser('programs_requests.update', $user);
    }
}
