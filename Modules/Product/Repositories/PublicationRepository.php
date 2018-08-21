<?php

namespace Modules\Product\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Publication;

class PublicationRepository
{
    /**
     * Lista todos os grupos.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  null|int  $perPage
     * @param  null|string  $filter
     * @return stdClass
     */
    public function index(User $user, $perPage = null, $filter = null)
    {
        // Verifica se o usuário pode realizar.
        if ($user->cant('index', Publication::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['reference', 'like', $filterLike],
            ]);
        };
        // Escopo.
        $scope = Publication::orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $publications = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'publications' => $publications
        ]);
    }

    /**
     * Tenta criar um novo grupo.
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
            return api_response(403);
        }
        $store = function () use ($user, $inputs, &$publication) {
            // Nova publicação.
            $publication = new Publication;
            // Preenche os campos indicados por input.
            $publication->fill($inputs);
            // Indica o usuário criador.
            $publication->user()
                ->associate($user);
            // Salva o produto.
            $publication->save();
            // Associa os projetos.
            $publication->projects()
                ->sync($inputs['projects']);
            // Associa os membros.
            $publication->members()
                ->sync($inputs['members'] ?? []);
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.publications.created'), [
            'publication' => $publication
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
        $publication = Publication::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $publication)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $publication) {
            // Atualiza os campos por input.
            $publication->update($inputs);
            // Sincroniza os projetos.
            $publication->projects()
                ->sync($inputs['projects']);
            // Sincroniza os membros.
            $publication->members()
                ->sync($inputs['members'] ?? []);                
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.publications.updated'), [
            'publication' => $publication
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
        $publication = Publication::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $publication)) {
            return api_response(403);
        }
        $destroy = function () use ($publication) {
            $publication->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.publications.deleted'));
    }
}
