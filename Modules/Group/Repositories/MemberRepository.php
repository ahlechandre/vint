<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Role;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Group\Entities\Member;
use Modules\Group\Entities\GroupRole;

class MemberRepository
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
        if ($user->cant('index', Member::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->whereHas('user', function ($user) use ($filterLike) {
                return $user->where('name', 'like', $filterLike);
            });
        };
        // Escopo.
        $scope = Member::approved()
            ->with('user')
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $members = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();
        $memberRequestsCount = Member::notApproved()
            ->count();

        return api_response(200, null, [
            'members' => $members,
            'memberRequestsCount' => $memberRequestsCount,
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
     * Lista todos os grupos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function requests(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('approve', Member::class) && $user->cant('deny', Member::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->whereHas('user', function ($user) use ($filterLike) {
                return $user->where('name', 'like', $filterLike);
            });
        };
        // Escopo.
        $scope = Member::notApproved()
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $members = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'members' => $members,
        ]);
    }

    /**
     * Tenta aprovar um ou vários membros.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $memberUserId
     * @param  array  $inputs
     * @return stdClass
     */
    public function approve(User $user, $memberUserId)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('approve', Member::class)) {
            return api_response(403);
        }
        $members = $memberUserId ?
            Member::notApproved()
                ->where('user_id', $memberUserId)
                ->get() :
            Member::notApproved()->get();

        $approve = function () use ($members) {
            $members->each(function ($member) {
                $member->is_approved = true;
                $member->save();
            });
        };

        try {
            // Tenta aprovar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.member_requests.approved'), [
            'members' => $members
        ]);
    }


    /**
     * Tenta recusar um ou mais membros.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $memberUserId
     * @param  array  $inputs
     * @return stdClass
     */
    public function deny(User $user, $memberUserId)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('deny', Member::class)) {
            return api_response(403);
        }
        $members = $memberUserId ?
            Member::notApproved()
                ->where('user_id', $memberUserId)
                ->get() :
            Member::notApproved()->get();

        $deny = function () use ($members) {
            $members->each(function ($member) {
                
                // Recusando aluno.
                if ($member->isStudent()) {
                    $member->student->forceDelete();
                }

                // Recusando servidor.
                if ($member->isServant()) {
                    $member->servant->forceDelete();
                }

                // Recusando colaborador.
                if ($member->isCollaborator()) {
                    $member->collaborator->forceDelete();
                }
                // Ao recusar um membro, todos os seus dados
                // devem ser removidos da base.
                $userToDelete = $member->user;
                $member->forceDelete();
                $userToDelete->forceDelete();
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.member_requests.denied'), [
            'members' => $members
        ]);
    }

}
