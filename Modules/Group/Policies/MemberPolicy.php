<?php

namespace Modules\Group\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;
use Modules\Group\Entities\Member;
use Modules\Group\Entities\Role;

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
     * Determine whether the user can index.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasAbility('users.index');
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToView
     * @return bool
     */
    public function view(User $user, User $userToView)
    {
        // Só pode visualizar se:
        // 1. Usuário não é administrador e possui habilidade para visualizar usuários.
        return !$userToView->isAdmin() && $user->hasAbility('users.view');
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAbility('users.create');
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function update(User $user, User $userToUpdate)
    {
        // Só pode atualizar o usuário se:
        // 1. O usuário for ele mesmo.
        // 2. Ele possuir habilidade de atualizar usuário e
        // o usuário não for administrador.
        return (
            $user->id === $userToUpdate->id
        ) || (
            !$userToUpdate->isAdmin() && $user->hasAbility('users.update')
        );
    }

    /**
     * Determine whether the user can update.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function updateRole(User $user, Member $member, Role $role)
    {
        // Só pode atualizar o usuário se:
        // 1. O usuário for ele mesmo.
        // 2. Ele possuir habilidade de atualizar usuário e
        // o usuário não for administrador.
        return (
            $user->id === $userToUpdate->id
        ) || (
            !$userToUpdate->isAdmin() && $user->hasAbility('users.update')
        );
    }

    /**
     * Determine whether the user can approve.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function approve(User $user)
    {
        // Só pode atualizar o usuário se:
        // 1. O usuário for ele mesmo.
        // 2. Ele possuir habilidade de atualizar usuário e
        // o usuário não for administrador.
        return (
            $user->id === $userToUpdate->id
        ) || (
            !$userToUpdate->isAdmin() && $user->hasAbility('users.update')
        );
    }

    /**
     * Determine whether the user can approve.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToUpdate
     * @return bool
     */
    public function deny(User $user)
    {
        // Só pode atualizar o usuário se:
        // 1. O usuário for ele mesmo.
        // 2. Ele possuir habilidade de atualizar usuário e
        // o usuário não for administrador.
        return (
            $user->id === $userToUpdate->id
        ) || (
            !$userToUpdate->isAdmin() && $user->hasAbility('users.update')
        );
    }

    /**
     * Determine whether the user can delete.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  \Modules\User\Entities\User  $userToDelete
     * @return bool
     */
    public function delete(User $user, User $userToDelete)
    {
        // Só pode remover o usuário se:
        // 1. O usuário for ele mesmo.
        // 2. Ele possuir habilidade de remover usuário e
        // o usuário não for administrador.
        return (
            $user->id === $userToDelete->id
        ) || (
            !$userToDelete->isAdmin() && $user->hasAbility('users.delete')
        );
    }
}
