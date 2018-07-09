<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\User\Entities\Client;

class ClientPolicy
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
        return $user->hasAbility('clients.index');
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Client  $client
     * @return bool
     */
    public function view(User $user, Client $client)
    {
        return $user->hasAbility('clients.view');
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAbility('clients.create');
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Client  $client
     * @return bool
     */
    public function update(User $user, Client $client)
    {
        return $user->hasAbility('clients.update');
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\Client  $client
     * @return bool
     */
    public function delete(User $user, Client $client)
    {
        return $user->hasAbility('clients.delete');
    }
}
