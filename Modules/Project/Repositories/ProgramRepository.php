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
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', Program::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['name', 'like', $filterLike],
            ]);
        };
        // Escopo.
        $scope = Program::approved()
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $programs = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();
        $programRequestsCount = Program::notApproved()
            ->count();

        return api_response(200, null, [
            'programs' => $programs,
            'programRequestsCount' => $programRequestsCount
        ]);
    }

    /**
     * Tenta criar um novo programa.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $program = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Program::class)) {
            return api_response(403);
        }
        $store = function () use ($user, $inputs, &$program) {
            // Se o programa for criado por um membro,
            // o grupo do programa é o mesmo do membro.
            // Caso contrário, o grupo será indicado por input.
            $group = $user->isMember() ?
                $user->member->group :
                Group::findOrFail($inputs['group_id']);
            // Novo programa.
            $program = new Program;
            // O grupo.
            $program->group()->associate($group);
            // O usuário criador.
            $program->user()->associate($user);
            // Preenche os dados indicados por inputs.
            $program->fill($inputs);
            // O programa não precisa ser aprovado se o usuário
            // não for um membro (e.g. administrador ou gerente).
            $program->is_approved = !$user->isMember();
            // Salva o novo programa.
            $program->save();
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.programs.created'), [
            'program' => $program
        ]);
    }

    /**
     * Tenta atualizar um usuário.
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
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $program) {
            $program->update($inputs);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.programs.updated'), [
            'program' => $program
        ]);
    }

    /**
     * Tenta atualizar um usuário.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function destroy(User $user, $id)
    {
        $program = Program::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $program)) {
            return api_response(403);
        }
        $destroy = function () use ($program) {
            $program->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.programs.deleted'));
    }

    /**
     * Lista todos as solicitações de programas.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function requests(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('indexRequests', Program::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where('name', 'like', $filterLike);
        };
        // Escopo.
        $scope = Program::notApproved()
            ->orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $programs = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'programs' => $programs,
        ]);
    }

    /**
     * Tenta aprovar um ou vários programas.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function approve(User $user, $id)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', Program::class)) {
            return api_response(403);
        }
        $programs = $id ?
            Program::notApproved()
                ->where('id', $id)
                ->get() :
            Program::notApproved()
                ->get();

        $approve = function () use ($programs) {
            $programs->each(function ($program) {
                $program->is_approved = true;
                $program->save();
            });
        };

        try {
            // Tenta aprovar.
            DB::transaction($approve);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.program_requests.approved'), [
            'programs' => $programs
        ]);
    }


    /**
     * Tenta recusar um ou mais programas.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|string  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function deny(User $user, $id)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('updateRequests', Program::class)) {
            return api_response(403);
        }
        $programs = $id ?
            Program::notApproved()
                ->where('id', $id)
                ->get() :
            Program::notApproved()
                ->get();

        $deny = function () use ($programs) {
            $programs->each(function ($program) {
                // Remove permanentemente o programa recusado.
                $program->forceDelete();
            });
        };

        try {
            // Tenta recusar.
            DB::transaction($deny);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.program_requests.denied'), [
            'programs' => $programs
        ]);
    }
}
