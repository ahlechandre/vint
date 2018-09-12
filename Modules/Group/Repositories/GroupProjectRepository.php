<?php

namespace Modules\Group\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Project;

class GroupProjectRepository
{
    /**
     * Lista todos os projetos aprovados do grupo.
     *
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function index($groupId, $perPage = null, $term = null)
    {
        $group = Group::findOrFail($groupId);

        return repository_result(200, null, [
            'group' => $group,
            'projects' => $group->projects()
                ->approved()
                ->filterLike($term)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Lista todos os projetos não aprovados do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  string|int  $groupId
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function requests(User $user, $groupId, $perPage = null, $term = null)
    {
        $group = Group::findOrFail($groupId);

        if ($user->cant('updateRequests', [Project::class, $group])) {
            return repository_result(403);
        }
        
        return repository_result(200, null, [
            'group' => $group,
            'projects' => $group->projects()
                ->notApproved()
                ->filterLike($term)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Tenta aprovar projetos no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  null|int|string  $projectId
     * @return stdClass
     */
    public function approve(User $user, $groupId, $projectId = null)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Project::class, $group])) {
            return repository_result(403);
        }
        $projects = $projectId ?
            $group->projects()
                ->notApproved()
                ->where('id', $projectId)
                ->get() :
            $group->projects()
                ->notApproved()
                ->get();

        $approve = function () use ($user, $group, $projects) {
            $projects->map(function ($project) {
                $project->is_approved = true;
                $project->save();
            });
        };

        try {
            // Tenta aprovar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.projects.approved'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta recusar projetos no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  null|int|string  $projectId
     * @return stdClass
     */
    public function deny(User $user, $groupId, $projectId = null)
    {
        $group = Group::findOrFail($groupId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', [Project::class, $group])) {
            return repository_result(403);
        }
        $projects = $projectId ?
            $group->projects()
                ->notApproved()
                ->where('id', $projectId)
                ->get() :
            $group->projects()
                ->notApproved()
                ->get();

        $deny = function () use ($user, $group, $projects) {
            $projects->map(function ($project) {
                // Se projeto for recusado, remove-o da base de dados.
                $project->forceDelete();
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.groups.projects.denied'), [
            'group' => $group
        ]);
    }

    /**
     * Tenta criar um novo projeto no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int|string  $groupId
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, $groupId, array $inputs)
    {
        $group = Group::findOrFail($groupId);
        $project = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', [Project::class, $group])) {
            return repository_result(403);
        }
        $store = function () use ($user, $group, $inputs, &$project) {
            // Novo projeto.
            $project = new Project;
            // O grupo.
            $project->group()->associate($group);
            // O usuário criador.
            $project->user()->associate($user);

            // O programa do projeto.
            if (isset($inputs['program_id'])) {
                $program = $group->programs()
                    ->approved()
                    ->findOrFail($inputs['program_id']);
                $project->program()->associate($program);
            }
            // Coordenador do projeto.
            $coordinatorMember = $group->servantMembers()
                ->findOrFail($inputs['coordinator_user_id']);
            $project->coordinator()
                ->associate($coordinatorMember->servant);
            
            // Orientador do projeto.
            if (isset($inputs['leader_user_id'])) {
                $leaderMember = $group->servantMembers()
                    ->findOrFail($inputs['leader_user_id']);
                $project->leader()
                    ->associate($leaderMember->servant);
            }

            // Apoiador do projeto.
            if (isset($inputs['supporter_user_id'])) {
                $supporterMember = $group->collaboratorMembers()
                    ->findOrFail($inputs['supporter_user_id']);
                $project->supporter()
                    ->associate($supporterMember->collaborator);
            }
            // Preenche os dados indicados por inputs.
            $project->fill($inputs);
            // O projeto não precisa ser aprovado se o usuário
            // pode atualizar solicitações de projetos no grupo
            // (i.e. administradores, gerentes e coordenadores).
            $project->is_approved = $user->can('updateRequests', [Project::class, $group]);
            // Salva o novo projeto.
            $project->save();
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.projects.created'), [
            'project' => $project
        ]);
    }
}
