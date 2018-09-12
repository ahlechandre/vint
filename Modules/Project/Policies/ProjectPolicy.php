<?php

namespace Modules\Project\Policies;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Project\Entities\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
     * @param  \Modules\Group\Entities\Group  $group
     * @return bool
     */
    public function create(User $user, Group $group)
    {
        return $user->isManager() ||
            $group->hasCoordinatorUser($user) ||
            $group->allowsForUser('projects.create', $user);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function update(User $user, Project $project)
    {
        $group = $project->group;

        if ($user->isManager() || $group->hasCoordinatorUser($user)) {
            return true;
        }
        $canUpdate = $group->allowsForUser('projects.update', $user);

        if (!$canUpdate) {
            return false;
        }
        $isRelated = $project->user_id === $user->id ||
            $project->coordinator_id === $user->id ||
            $project->leader_user_id === $user->id ||
            $project->supporter_user_id === $user->id ||
            $project->students()->find($user->id);

        return $isRelated;
    }

    /**
     *
     * @param \Modules\User\Entities\User $user
     * @param \Modules\Project\Entities\Project $project
     * @return bool
     */
    public function delete(User $user, Project $project)
    {
        return $user->isManager();
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function updateRequests(User $user, Group $group)
    {
        return $user->isManager() ||
            $group->isCoordinatorUser($user) ||
            $group->allowsForUser('projects_requests.update', $user);
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function createStudents(User $user, Project $project)
    {
        return $this->update($user, $project);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function updateStudents(User $user, Project $project)
    {
        return $this->update($user, $project);
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function deleteStudents(User $user, Project $project)
    {
        return $this->update($user, $project);
    }
}
