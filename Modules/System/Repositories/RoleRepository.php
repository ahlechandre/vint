<?php

namespace Modules\System\Repositories;

use Exception;
use Modules\System\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
    /**
     * Lista todos os papéis.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', Role::class)) {
            return repository_result(403, __('messages.status.403'));
        }
        $search = function ($filter) {
            $filterLike = "%{$filter}%";

            return Role::where([
                ['name', 'like', $filterLike],
            ]);
        };
        $query = $filter ?
            $search($filter) :
            Role::orderBy('created_at', 'desc');
        $roles = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return repository_result(200, null, [
            'roles' => $roles,
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
        $role = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Role::class)) {
            return repository_result(403);
        }
        $store = function () use ($inputs, &$role) {
            $role = Role::create($inputs);
            $role->abilities()->sync($inputs['abilities'] ?? []);
        };

        try {
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.roles.created'), [
            'role' => $role
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
        $role = Role::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $role)) {
            return repository_result(403, __('messages.status.403'), [
                'role' => $role,
            ]);
        }
        $update = function () use ($user, $inputs, $role) {
            $role->update($inputs);

            if (isset($inputs['abilities'])) {
                $role->abilities()
                    ->sync($inputs['abilities']);
            }
        };

        try {
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.roles.updated'), [
            'role' => $role
        ]);
    }
}
