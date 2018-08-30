<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;

class GroupProgramRepository
{
    /**
     * Lista todos os programas do grupo.
     *
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($groupId, $perPage = null, $filter = null)
    {
        $group = Group::findOrFail($groupId);

        return repository_result(200, null, [
            'group' => $group,
            'programRequestsCount' => $group->programs()
                ->notApproved()
                ->count(),
            'programs' => $group->programs()
                ->approved()
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
}
