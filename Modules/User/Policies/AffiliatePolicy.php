<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\User\Entities\Affiliate;

class AffiliatePolicy
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
        return $user->hasAbility('affiliates.index');
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Affiliate  $affiliate
     * @return bool
     */
    public function view(User $user, Affiliate $affiliate)
    {
        return $user->hasAbility('affiliates.view');
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAbility('affiliates.create');
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Affiliate  $affiliate
     * @return bool
     */
    public function update(User $user, Affiliate $affiliate)
    {
        return $user->hasAbility('affiliates.update');
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Affiliate  $affiliate
     * @return bool
     */
    public function delete(User $user, Affiliate $affiliate)
    {
        return $user->hasAbility('affiliates.delete');
    }
}
