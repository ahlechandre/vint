<?php

namespace Modules\Project\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Project;

class ProjectStudentRepository
{
    /**
     * Tenta adicionar um coordenador no grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $projectId
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, $projectId, array $inputs)
    {
        $project = Project::findOrFail($projectId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('createStudents', $project)) {
            return api_response(403);
        }
        $store = function () use ($inputs, $project) {
            $project->students()
                ->attach($inputs['student_user_id'], [
                    'is_scholarship' => $inputs['is_scholarship']
                ]);
        };

        DB::transaction($store);

        try {
            // Tenta adicionar.
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.project_students.created'), [
            'project' => $project,
        ]);
    }

    /**
     * Tenta atualizar um convite do grupo.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $projectId
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $projectId, $id, array $inputs)
    {
        $project = Project::findOrFail($projectId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('updateStudents', $project)) {
            return api_response(403);
        }
        $update = function () use ($inputs, $project, $id) {
            $project->students()
                ->updateExistingPivot($id, [
                    'is_scholarship' => $inputs['is_scholarship']
                ]);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.project_students.updated'), [
            'project' => $project
        ]);
    }

    /**
     * Tenta remover um convite.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $projectId
     * @param  int  $id
     * @return stdClass
     */
    public function destroy(User $user, $projectId, $id)
    {
        $project = Project::findOrFail($projectId);

        // Verifica se o usuário pode realizar.
        if ($user->cant('deleteStudents', $project)) {
            return api_response(403);
        }
        $destroy = function () use ($project, $id) {
            $project->students()
                ->detach($id);
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.students.deleted'), [
            'project' => $project
        ]);
    }
}
