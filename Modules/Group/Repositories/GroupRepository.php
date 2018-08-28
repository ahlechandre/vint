<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Role;
use Modules\Group\Entities\GroupRole;

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
            return repository_result(403);
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

        return repository_result(200, null, [
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


    /**
     * Tenta atualizar um usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $id
     * @param  int|string  $memberUserId
     * @return stdClass
     */
    public function approveMembers(User $user, $id, $memberUserId)
    {
        $group = Group::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateMemberRequests', $group)) {
            return repository_result(403);
        }
        $members = $memberUserId ?
            $group->membersNotApproved()
                ->where('user_id', $memberUserId)
                ->get() :
            $group->membersNotApproved()
                ->get();

        $approve = function () use ($user, $group, $members) {
            $members->map(function ($member) use ($group) {
                return $group->membersNotApproved()
                    ->updateExistingPivot($member->user_id, [
                        'is_approved' => true
                    ]);
            });
        };

        try {
            // Tenta atualizar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.member_requests.approved'), [
            'group' => $group
        ]);
    }


    /**
     * Tenta atualizar um usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $id
     * @param  int|string  $memberUserId
     * @return stdClass
     */
    public function denyMembers(User $user, $id, $memberUserId)
    {
        $group = Group::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateMemberRequests', $group)) {
            return repository_result(403);
        }
        $members = $memberUserId ?
            $group->members()
                ->where('user_id', $memberUserId)
                ->get() :
            $group->members()
                ->get();

        $deny = function () use ($user, $group, $members) {
            $members->map(function ($member) use ($group) {
                return $group->members()
                    ->detach($member->user_id);
            });
        };

        try {
            // Tenta atualizar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.member_requests.denied'), [
            'group' => $group
        ]);
    }    
}
