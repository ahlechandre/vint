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
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function index($perPage = null, $term = null)
    {
        return repository_result(200, null, [
            'projects' => Project::orderBy('created_at')
                ->filterLike($term)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Lista todas as publicações do projeto.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function publications($id, $perPage = null, $term = null)
    {
        $project = Project::findOrFail($id);

        return repository_result(200, null, [
            'project' => $project,
            'publications' => $project->publications()
                ->orderBy('created_at')
                ->filterLike($term)
                ->simplePaginate($perPage),
        ]);
    }

    /**
     * Lista todos produtos do projeto.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $term
     * @return stdClass
     */
    public function products($id, $perPage = null, $term = null)
    {
        $project = Project::findOrFail($id);

        return repository_result(200, null, [
            'project' => $project,
            'products' => $project->products()
                ->orderBy('created_at')
                ->filterLike($term)
                ->simplePaginate($perPage),
        ]);
    }

    /**
     * Tenta atualizar um projeto.
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
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $project) {
            // Associa o programa, se existir.
            $program = isset($inputs['program_id']) ?
                $project->group
                    ->programs()
                    ->findOrFail($inputs['program_id']) :
                null;
            $project->program()->associate($program);
            // Associa o coordenador.
            $coordinator = $project->group
                ->servantMembers()
                ->findOrFail($inputs['coordinator_user_id'])
                ->servant;
            $project->coordinator()->associate($coordinator);
            // Associa o orientador, se existir.
            $leader = isset($inputs['leader_user_id']) ?
                $project->group
                    ->servantMembers()
                    ->find($inputs['leader_user_id'])
                    ->servant :
                null;
            $project->leader()->associate($leader);
            // Associa o apoiador, se existir.
            $supporter = isset($inputs['supporter_user_id']) ? 
                $project->group
                    ->collaboratorMembers()
                    ->findOrFail($inputs['supporter_user_id'])
                    ->collaborator :
                null;
            $project->supporter()->associate($supporter);
            // Preenche os demais campos.
            $project->fill($inputs);
            // Salva.
            $project->save();
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.projects.updated'), [
            'project' => $project
        ]);
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|int  $term
     * @return void
     */
    public function forUser(User $user, $perPage = null, $term = null)
    {
        return repository_result(200, null, [
            'projects' => Project::with('group')
                ->forUser($user)
                ->filterLike($term)
                ->simplePaginate($perPage)
        ]);
    }
}
