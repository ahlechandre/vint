<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Member\Entities\Role;
use Modules\Group\Entities\GroupRole;

class GroupRepository
{
    /**
     * Lista todos os grupos.
     *
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($perPage = null, $filter = null)
    {
        return repository_result(200, null, [
            'groups' => Group::orderBy('created_at', 'desc')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
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
            return repository_result(403);
        }
        $store = function () use ($user, $inputs, &$group) {
            $group = Group::create($inputs);
            // Associa os papéis ao grupo.
            $groupRoles = Role::all()->map(function ($role) {
                return new GroupRole(['role_id' => $role->id]);
            });
            $group->groupRoles()
                ->saveMany($groupRoles);
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.created'), [
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
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $group) {
            $group->update($inputs);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.updated'), [
            'group' => $group
        ]);
    }   
}
