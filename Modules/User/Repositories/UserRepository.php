<?php

namespace Modules\User\Repositories;

use Exception;
use Modules\System\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * Lista todos os usuários.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @param  null|array  $queries
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(User $user, $perPage = null, $filter = null, $queries = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', User::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['name', 'like', $filterLike],
            ]);
        };
        $role = isset($queries['role']) ?
            Role::where('slug', $queries['role'])
                ->firstOrFail() :
            null;
        // Escopo por papel.
        $scope = $role ?
            User::where('role_id', $role->id)
                ->orderBy('created_at', 'desc') :
            User::orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona os usuários.
        $users = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'users' => $users
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
            return api_response(403);
        }
        $store = function () use ($user, $inputs, &$userCreated) {
            $role = Role::ofUser($user)
                ->active()
                ->findOrFail($inputs['role_id']);
            $userCreated = $role->users()
                ->create($inputs);
            
            if ($userCreated->isDriver()) {
                // Cria o registro específico de motorista.
                return $userCreated->driver()
                    ->create($inputs['driver'] ?? []);
            }

            if ($userCreated->isAffiliateUser()) {       
                // Sincroniza as filiais do usuário.
                return $userCreated->affiliates()
                    ->sync($inputs['affiliates'] ?? []);
            }
        };

        try {
            // Tenta criar o usuário.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.users.created'), [
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
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $userToUpdate) {
            $role = Role::ofUser($user)
                ->active()
                ->findOrFail($inputs['role_id']);
            $userToUpdate->update($inputs);

            if ($userToUpdate->isDriver() && isset($inputs['driver'])) {
                // Atualiza o registro específico de motorista.
                return $userToUpdate->driver()
                    ->update($inputs['driver']);
            }

            if ($userToUpdate->isAffiliateUser() && isset($inputs['affiliates'])) {
                // Sincroniza as filiais do usuário.
                return $userToUpdate->affiliates()
                    ->sync($inputs['affiliates']);
            }
        };

        try {
            // Tenta atualizar o usuário.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.users.updated'), [
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
    public function updatePassword(User $user, $id, array $inputs)
    {
        $userToUpdate = User::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToUpdate)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $userToUpdate) {
            $userToUpdate->update([
                'password' => $inputs['password']
            ]);
        };

        try {
            // Tenta atualizar o usuário.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.auth.updated'), [
            'userUpdated' => $userToUpdate
        ]);
    }
}
