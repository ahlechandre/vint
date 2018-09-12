<?php

namespace Modules\User\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\UserType;

class UserRepository
{
    /**
     * Lista todos os usuários.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(User $user, $perPage = null, $term = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', User::class)) {
            return repository_result(403);
        }

        return repository_result(200, null, [
            'users' => User::filterLike($term)
                ->orderBy('created_at', 'desc')
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Tenta criar um novo usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $userCreated = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', User::class)) {
            return repository_result(403);
        }
        $store = function () use ($user, $inputs, &$userCreated) {
            // Seleciona o papel do usuário a ser criado, disponível
            // para o usuário da requisição e que esteja disponível
            // para formulários.
            $role = UserType::ofUser($user)
                ->findOrFail($inputs['user_type_id']);
            $userCreated = new User;
            $userCreated->fill($inputs);
            $userCreated->userType()->associate($role);
            $userCreated->save();
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.users.created'), [
            'userCreated' => $userCreated
        ]);
    }

    /**
     * Tenta atualizar um usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $id, array $inputs)
    {
        $userToUpdate = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToUpdate)) {
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $userToUpdate) {
            // Seleciona o papel do usuário a ser criado, disponível
            // para o usuário da requisição e que esteja disponível
            // para formulários.            
            $userType = UserType::ofUser($user)
                ->findOrFail($inputs['user_type_id']);
            // Atualiza os inputs com "mass assingment".
            $userToUpdate->update($inputs);

            // Atualiza "is_active" se necessitar.
            if ((int) $inputs['is_active'] !== $userToUpdate->is_active) {
                $userToUpdate->is_active = !$userToUpdate->is_active;
                $userToUpdate->save();
            }
            // Atualiza o tipo sem "mass assignament".
            $userToUpdate->userType()
                ->associate($userType)
                ->save();
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.users.updated'), [
            'userUpdated' => $userToUpdate
        ]);
    }

    /**
     * Tenta atualizar a senha de um usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function password(User $user, $id, array $inputs)
    {
        $userToUpdate = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToUpdate)) {
            return repository_result(403);
        }
        $update = function () use ($userToUpdate, $inputs) {
            $userToUpdate->update([
                'password' => $inputs['password']
            ]);
        };

        try {
            // Tenta atualizar o usuário.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.users.password_updated'), [
            'userUpdated' => $userToUpdate
        ]);
    }
}
