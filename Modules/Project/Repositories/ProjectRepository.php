<?php

namespace Modules\Project\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Project;

class ProjectRepository
{
    /**
     * Lista todos os projetos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', Project::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['name', 'like', $filterLike],
            ]);
        };
        // Escopo.
        $scope = Project::approved()
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $projects = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();
        $projectRequestsCount = Project::notApproved()
            ->count();

        return api_response(200, null, [
            'projects' => $projects,
            'projectRequestsCount' => $projectRequestsCount
        ]);
    }

    /**
     * Tenta criar um novo projeto.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $project = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Project::class)) {
            return api_response(403);
        }
        $store = function () use ($user, $inputs, &$project) {
            // Se o projeto for criado por um membro,
            // o grupo do projeto é o mesmo do membro.
            // Caso contrário, o grupo será indicado por input.
            $group = $user->isMember() ?
                $user->member->group :
                Group::findOrFail($inputs['group_id']);

            if (isset($inputs['project_id'])) {
                // Verifica se o projecta indicado está aprovado 
                // e no mesmo grupo.
                $project = Project::ofGroup($group)
                    ->approved()
                    ->findOrFail($inputs['project_id']);
            }
            // Novo projeto.
            $project = new Project;
            // O grupo.
            $project->group()->associate($group);
            // O usuário criador.
            $project->user()->associate($user);
            // Preenche os dados indicados por inputs.
            $project->fill($inputs);
            // O projeto não precisa ser aprovado se o usuário
            // não for um membro (e.g. administrador ou gerente).
            $project->is_approved = !$user->isMember();
            // Salva o novo projeto.
            $project->save();
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.projects.created'), [
            'project' => $project
        ]);
    }

    /**
     * Tenta atualizar um projecta.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $id, array $inputs)
    {
        $project = Project::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $project)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $project) {
            $project->update($inputs);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.projects.updated'), [
            'project' => $project
        ]);
    }

    /**
     * Lista todos as solicitações de projetos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function requests(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('indexRequests', Project::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where('name', 'like', $filterLike);
        };
        // Escopo.
        $scope = Project::notApproved()
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $projects = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'projects' => $projects,
        ]);
    }

    /**
     * Tenta aprovar um ou vários projetos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function approve(User $user, $id)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', Project::class)) {
            return api_response(403);
        }
        $projects = $id ?
            Project::notApproved()
                ->where('id', $id)
                ->get() :
            Project::notApproved()
                ->get();

        $approve = function () use ($projects) {
            $projects->each(function ($project) {
                $project->is_approved = true;
                $project->save();
            });
        };

        try {
            // Tenta aprovar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.project_requests.approved'), [
            'projects' => $projects
        ]);
    }


    /**
     * Tenta recusar um ou mais projetos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function deny(User $user, $id)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', Project::class)) {
            return api_response(403);
        }
        $projects = $id ?
            Project::notApproved()
                ->where('id', $id)
                ->get() :
            Project::notApproved()
                ->get();

        $deny = function () use ($projects) {
            $projects->each(function ($project) {
                // Desassocia todos os alunos.
                $project->students()
                    ->sync([]);
                // Remove permanentemente o projecta recusado.
                $project->forceDelete();
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.project_requests.denied'), [
            'projects' => $projects
        ]);
    }
}
