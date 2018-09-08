<?php

namespace Modules\Product\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Project\Entities\Project;

class ProductRepository
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
            'products' => Product::orderBy('created_at')
                ->filterLike($filter)
                ->simplePaginateOrGet($perPage)
        ]);
    }

    /**
     * Tenta criar um novo produto.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  array  $inputs
     * @return stdClass
     */
    public function store(User $user, array $inputs)
    {
        $product = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Product::class)) {
            return repository_result(403);
        }
        $store = function () use ($user, $inputs, &$product) {
            // Novo produto.
            $product = new Product;
            // Preenche os campos indicados por input.
            $product->fill($inputs);
            // Indica o usuário criador.
            $product->user()
                ->associate($user);
            // Salva o produto.
            $product->save();
            // Verifica se todos os projetos indicados estão disponíveis
            // para o usuário.
            $projects = Project::forUser($user)
                ->findOrFail($inputs['projects']);
            // Associa os projetos.
            $product->projects()
                ->sync($projects->pluck('id'));
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.products.created'), [
            'product' => $product
        ]);
    }

    /**
     * Tenta atualizar um produto.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function update(User $user, $id, array $inputs)
    {
        $product = Product::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $product)) {
            return repository_result(403);
        }
        $update = function () use ($user, $inputs, $product) {
            // Atualiza os campos por input.
            $product->update($inputs);
            // Verifica se todos os projetos indicados estão disponíveis
            // para o usuário.
            $projects = Project::forUser($user)
                ->findOrFail($inputs['projects']);
            // Associa os projetos.
            $product->projects()
                ->sync($projects->pluck('id'));
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.products.updated'), [
            'product' => $product
        ]);
    }

    /**
     * Tenta remover um produto.
     *
     * @param  \Modules\User\Entities\User  $user
     * @param  int  $id
     * @param  array  $inputs
     * @return stdClass
     */
    public function destroy(User $user, $id)
    {
        $product = Product::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $product)) {
            return repository_result(403);
        }
        $destroy = function () use ($product) {
            $product->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return repository_result(500);
        }

        return repository_result(200, __('messages.products.deleted'));
    }    
}
