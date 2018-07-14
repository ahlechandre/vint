<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    /**
     * Lista todos os grupos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', Group::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['name', 'like', $filterLike],
            ]);
        };
        // Escopo.
        $scope = Group::orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $groups = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'groups' => $groups
        ]);
    }

    /**
     * Tenta criar um novo grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $group = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Group::class)) {
            return api_response(403);
        }
        $store = function () use ($user, $inputs, &$group) {
            $group = Group::create($inputs);       
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.groups.created'), [
            'group' => $group
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
        $group = Group::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $group)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $group) {
            $group->update($inputs);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.groups.updated'), [
            'group' => $group
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
