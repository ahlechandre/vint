<?php

namespace Modules\Product\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Publication;
use Modules\Project\Entities\Project;
use Modules\Member\Entities\Member;

class PublicationRepository
{
    /**
     * Lista todos os produtos.
     *
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index($perPage = null, $filter = null)
    {
        return repository_result(200, null, [
            'publications' => Publication::orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Lista todos projetos da publicação.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function projects($id, $perPage = null, $filter = null)
    {
        $publication = Publication::findOrFail($id);

        return repository_result(200, null, [
            'publication' => $publication,
            'projects' => $publication->projects()
                ->orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginate($perPage)
        ]);
    }

    /**
     * Lista todos membros da publicação.
     *
     * @param  string|int  $id
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function members($id, $perPage = null, $filter = null)
    {
        $publication = Publication::findOrFail($id);

        return repository_result(200, null, [
            'publication' => $publication,
            'members' => $publication->members()
                ->with('user')
                ->filterLike($filter)
                ->simplePaginate($perPage)
        ]);
    }

    /**
     * Tenta criar um nova publicação.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $publication = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Publication::class)) {
            return repository_result(403);
        }
        $store = function () use ($user, $inputs, &$publication) {
            // Novo produto.
            $publication = new Publication;
            // Preenche os campos indicados por input.
            $publication->fill($inputs);
            // Indica o usuário criador.
            $publication->user()
                ->associate($user);
            // Salva o produto.
            $publication->save();
            // Verifica se todos os projetos indicados estão disponíveis
            // para o usuário.
            $projects = Project::forUser($user)
                ->findOrFail($inputs['projects']);
            // Associa os projetos.
            $publication->projects()
                ->sync($projects->pluck('id'));
            
            if (isset($inputs['members'])) {
                // Verifica se todos os membros indicados estão disponíveis
                // para o usuário.
                $members = Member::forUser($user)
                    ->findOrFail($inputs['members']);
                // Associa os membros.
                $publication->members()
                    ->sync($members->pluck('user_id'));
            }
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.publications.created'), [
            'publication' => $publication
        ]);
    }

    /**
     * Tenta atualizar uma publicação.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $id, array $inputs)
    {
        $publication = Publication::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $publication)) {
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $publication) {
            // Atualiza os campos por input.
            $publication->update($inputs);
            // Verifica se todos os projetos indicados estão disponíveis
            // para o usuário.
            $projects = Project::forUser($user)
                ->findOrFail($inputs['projects']);
            // Associa os projetos.
            $publication->projects()
                ->sync($projects->pluck('id'));

            // Se existem membros.
            if (isset($inputs['members'])) {
                // Verifica se todos os membros indicados estão disponíveis
                // para o usuário.
                $members = Member::forUser($user)
                    ->findOrFail($inputs['members']);
                // Associa os membros.
                $publication->members()
                    ->sync($members->pluck('user_id'));

                return;
            }
            // Se não existem membros, remova-os.
            $publication->members()
                ->sync([]);            
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.publications.updated'), [
            'publication' => $publication
        ]);
    }

    /**
     * Tenta remover uma publicação.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function destroy(User $user, $id)
    {
        $publication = Publication::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $publication)) {
            return repository_result(403);
        }
        $destroy = function () use ($publication) {
            $publication->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.publications.deleted'));
    }    
}
