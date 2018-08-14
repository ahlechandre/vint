<?php

namespace Modules\Project\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;

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
     * Determine whether the user can index.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToView
     * @return bool
     */
    public function view(User $user, Project $project)
    {
        return true;
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function createStudents(User $user, Project $project)
    {
        return true;
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
        return true;
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
        return true;
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
        return true;
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function updateRequests(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function indexRequests(User $user)
    {
        return false;
    }
}
