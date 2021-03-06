<?php

namespace Modules\Group\Policies;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Member\Entities\Role;
use Modules\Member\Entities\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
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
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function update(User $user, Member $member)
    {
        return $user->isManager() || (
            $user->id === $member->user_id
        );
    }

    /**
     *
     * @param \Modules\User\Entities\User $user
     * @param \Modules\Group\Entities\Group $group
     * @return bool
     */
    public function updateRequests(User $user, Group $group)
    {        
        return $user->isManager() ||
            $group->hasCoordinatorUser($user) ||
            $group->allowsForUser('members_requests.update', $user);
    }

}
