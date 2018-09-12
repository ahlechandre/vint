<?php

namespace Modules\Product\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\Product\Entities\Product;

class ProductPolicy
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
        // Poderia criar se existem projetos para o usuário.
        // return Project::forUser($user)->exists();
        return true;
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Product\Entities\Product  $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        return $user->isManager() || $product->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\Product\Entities\Product  $product
     * @return bool
     */
    public function delete(User $user, Product $product)
    {
        return $user->isManager() || $product->user_id === $user->id;
    }
}
