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
     * Tenta atualizar um membro.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $userId
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $userId, array $inputs)
    {
        $member = Member::approved()
            ->findOrFail($userId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $member)) {
            return api_response(403);
        }

        $update = function () use ($user, $inputs, $member) {
            // Atualiza os dados gerais.
            $member->update($inputs);

            // Verifica se é atualização de aluno.
            if ($member->isStudent()) {
                return $member->student
                    ->update($inputs['student']);
            }

            // Verifica se é atualização de servidor.
            if ($member->isServant()) {
                return $member->servant
                    ->update($inputs['servant']);
            }

            // Verifica se é atualização de colaborador.
            if ($member->isCollaborator()) {
                return $member->collaborator
                    ->update();
            }
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.members.updated'), [
            'member' => $member
        ]);
    }

    /**
     * Tenta atualizar o papel de membro.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $userId
     * @param  int|string  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function role(User $user, $userId, $id, array $inputs)
    {
        // Acessa o membro.
        $member = Member::approved()
            ->findOrFail($userId);
        // Acessa o novo papel do membro.
        $role = Role::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRole', [$member, $role])) {
            return api_response(403);
        }

        $update = function () use ($user, $inputs, $member, $role) {
            // Atualiza o papel do membro.
            $member->role()->associate($role);
            $member->save();

            // Verifica se é atualização de aluno.
            if ($member->isStudent()) {
                // Se o membro já possuir especificação de aluno, apenas atualiza.
                // Caso contrário, cria.
                return $member->student ?
                    $member->student
                        ->update($inputs['student']) :
                    $member->student()
                        ->create($inputs['student']);
            }

            // Verifica se é atualização de servidor.
            if ($member->isServant()) {
                // Se o membro já possuir especificação de servidor, apenas atualiza.
                // Caso contrário, cria.
                return $member->servant ?
                    $member->servant
                        ->update($inputs['servant']) :
                    $member->servant()
                        ->create($inputs['servant']);
            }

            // Verifica se é atualização de colaborador.
            if ($member->isCollaborator()) {
                // Se o membro já possuir especificação de colaborador, apenas atualiza.
                // Caso contrário, cria.
                return $member->collaborator ?
                    $member->collaborator
                        ->update() :
                    $member->collaborator()
                        ->create();
            }
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.members.role.updated'), [
            'member' => $member,
            'role' => $role
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
            Member::notApproved()
                ->with('user')
                ->get();

        $approve = function () use ($members) {
            $members->each(function ($member) {
                // Ativa o usuário.
                $member->user->is_active = true;
                $member->user->save();
                // Aprova o membro.
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