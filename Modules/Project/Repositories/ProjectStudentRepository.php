<?php

namespace Modules\Project\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Project;

class ProjectStudentRepository
{

    /**
     * Lista todos os alunos do projeto.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($id, $perPage = null, $filter = null)
    {
        $project = Project::findOrFail($id);
        $students = $project->students()
            ->orderBy('project_student.created_at')
            ->with('member.user')
            ->filterLike($filter)
            ->get();

        return repository_result(200, null, [
            'project' => $project,
            'students' => $students
        ]);
    }

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
            return repository_result(403);
        }
        $store = function () use ($inputs, $project) {
            // Verifica se o aluno indicado é um aluno do grupo.
            $studentMember = $project->group
                ->studentMembers()
                ->findOrFail($inputs['student_user_id']);

            $project->students()
                ->syncWithoutDetaching([
                    $studentMember->user_id => [
                        'is_scholarship' => $inputs['is_scholarship']
                    ]
                ]);
        };

        try {
            // Tenta adicionar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.project_students.created'), [
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
            return repository_result(403);
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
            return repository_result(500);
        }

        return repository_result(200, __('messages.project_students.updated'), [
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
            return repository_result(403);
        }
        $destroy = function () use ($project, $id) {
            $project->students()
                ->detach($id);
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.students.deleted'), [
            'project' => $project
        ]);
    }
}
