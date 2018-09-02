<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Program;

class GroupProgramRepository
{
    /**
     * Lista todos os programas aprovados do grupo.
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
            'programs' => $group->programs()
                ->approved()
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Lista todos os programas não aprovados do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function requests(User $user, $groupId, $perPage = null, $filter = null)
    {
        $group = Group::findOrFail($groupId);

        if ($user->cant('updateRequests', [Program::class, $group])) {
            return repository_result(403);
        }
        
        return repository_result(200, null, [
            'group' => $group,
            'programs' => $group->programs()
                ->notApproved()
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Tenta aprovar programas no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  null|int|string  $programId
     * @return stdClass
     */
    public function approve(User $user, $groupId, $programId = null)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Program::class, $group])) {
            return repository_result(403);
        }
        $programs = $programId ?
            $group->programs()
                ->notApproved()
                ->where('id', $programId)
                ->get() :
            $group->programs()
                ->notApproved()
                ->get();

        $approve = function () use ($user, $group, $programs) {
            $programs->map(function ($program) {
                $program->is_approved = true;
                $program->save();
            });
        };

        try {
            // Tenta aprovar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.programs.approved'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta recusar programas no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  int|string  $memberUserId
     * @return stdClass
     */
    public function deny(User $user, $groupId, $memberUserId)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Program::class, $group])) {
            return repository_result(403);
        }
        $programs = $programId ?
            $group->programs()
                ->notApproved()
                ->where('id', $programId)
                ->get() :
            $group->programs()
                ->notApproved()
                ->get();

        $deny = function () use ($user, $group, $programs) {
            $programs->map(function ($program) {
                // Se programa for recusado, remove-o da base de dados.
                $program->forceDelete();
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.programs.denied'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta criar um novo programa no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, $groupId, array $inputs)
    {
        $group = Group::findOrFail($groupId);
        $program = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', [Program::class, $group])) {
            return repository_result(403);
        }
        $store = function () use ($user, $group, $inputs, &$program) {
            // Novo programa.
            $program = new Program;
            // O grupo.
            $program->group()->associate($group);
            // O usuário criador.
            $program->user()->associate($user);
            // Preenche os dados indicados por inputs.
            $program->fill($inputs);
            // O programa não precisa ser aprovado se o usuário
            // pode atualizar solicitações de programas no grupo
            // (i.e. administradores, gerentes e coordenadores).
            $program->is_approved = $user->can('updateRequests', [Program::class, $group]);
            // Salva o novo programa.
            $program->save();
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.programs.created'), [
            'program' => $program
        ]);
    }
}
