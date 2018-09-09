<?php

namespace Modules\Member\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Member\Entities\Role;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Member\Entities\Member;
use Modules\Member\Entities\GroupRole;
use Modules\Project\Entities\Program;
use Modules\Project\Entities\Project;
use Modules\Product\Entities\Publication;

class MemberRepository
{
    /**
     * Lista todos os membros.
     *
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($perPage = null, $filter = null)
    {
        return repository_result(200, null, [
            'members' => Member::orderBy('created_at')
                ->with('user')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Lista todos os programas do membro.
     *
     * @param  int|string  $userId
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function programs($userId, $perPage = null, $filter = null)
    {
        $member = Member::findOrFail($userId);

        return repository_result(200, null, [
            'member' => $member,
            'programs' => Program::ofMember($member)
                ->orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Lista todos os projetos do membro.
     *
     * @param  int|string  $userId
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function projects($userId, $perPage = null, $filter = null)
    {
        $member = Member::findOrFail($userId);

        return repository_result(200, null, [
            'member' => $member,
            'projects' => Project::ofMember($member)
                ->orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Lista todas as publicações do membro.
     *
     * @param  int|string  $userId
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function publications($userId, $perPage = null, $filter = null)
    {
        $member = Member::findOrFail($userId);

        return repository_result(200, null, [
            'member' => $member,
            'publications' => Publication::approved()
                ->ofMember($member)
                ->orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
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

        DB::transaction($update);
        try {
            // Tenta atualizar.
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
     * @param  int|string  $roleId
     * @param  array  $inputs
     * @return stdClass
     */
    public function role(User $user, $userId, $roleId, array $inputs)
    {
        // Acessa o membro.
        $member = Member::findOrFail($userId);
        // Acessa o novo papel do membro.
        $role = Role::findOrFail($roleId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $member)) {
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

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|int  $filter
     * @return void
     */
    public function forUser(User $user, $perPage = null, $filter = null)
    {
        return repository_result(200, null, [
            'members' => Member::forUser($user)
                ->with('user')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
        ]);
    }    
}
