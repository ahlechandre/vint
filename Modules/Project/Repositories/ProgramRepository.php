<?php

namespace Modules\Project\Repositories;

use Exception;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Support\Facades\DB;
use Modules\Project\Entities\Program;

class ProgramRepository
{
    /**
     * Lista todos os programas.
     *
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($perPage = null, $filter = null)
    {
        return repository_result(200, null, [
            'programs' => Program::orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Lista todos os projetos do programa.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function projects($id, $perPage = null, $filter = null)
    {
        $program = Program::findOrFail($id);

        return repository_result(200, null, [
            'program' => $program,
            'projects' => $program->projects()
                ->orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage),
        ]);
    }

    /**
     * Tenta atualizar um programa.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $id, array $inputs)
    {
        $program = Program::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $program)) {
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $program) {
            // Coordenador do programa deve ser um servidor aprovado
            // no grupo.
            $coordinatorMember = $program->group
                ->servantMembers()
                ->findOrFail($inputs['coordinator_user_id']);
            $program->coordinator()
                ->associate($coordinatorMember->servant);
            // Preenche os demais campos.
            $program->fill($inputs);
            // Salva.
            $program->save();
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.programs.updated'), [
            'program' => $program
        ]);
    }
}
