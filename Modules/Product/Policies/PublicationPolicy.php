<?php

namespace Modules\Product\Policies;

use Modules\User\Entities\User;
use Modules\Product\Entities\Publication;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicationPolicy
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
        // Poderia criar se existir projetos disponíveis.
        // return Project::forUser($user)->exists();
        return true;
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Product\Entities\Publication  $publication
     * @return bool
     */
    public function update(User $user, Publication $publication)
    {
        return $user->isManager() ||
            $publication->user_id === $user->id ||
            $publication->members()->find($user->id);
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Product\Entities\Publication  $publication
     * @return bool
     */
    public function delete(User $user, Publication $publication)
    {
        return $user->isManager() || $publication->user_id === $user->id;
    }
}
