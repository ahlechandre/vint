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
            return repository_result(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->whereHas('user', function ($user) use ($filterLike) {
                return $user->where('name', 'like', $filterLike);
            });
        };
        // Escopo.
        $scope = Member::with('user')
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $members = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return repository_result(200, null, [
            'members' => $members,
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
        $member = Member::findOrFail($userId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $member)) {
            return repository_result(403);
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
            return repository_result(500);
        }

        return repository_result(200, __('messages.members.updated'), [
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
        $member = Member::findOrFail($userId);
        // Acessa o novo papel do membro.
        $role = Role::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRole', [$member, $role])) {
            return repository_result(403);
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
            return repository_result(500);
        }

        return repository_result(200, __('messages.members.role.updated'), [
            'member' => $member,
            'role' => $role
        ]);
    }
}
