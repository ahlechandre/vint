<?php

namespace Modules\Product\Repositories;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;

class ProductRepository
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
        if ($user->cant('index', Product::class)) {
            return api_response(403);
        }
        $search = function ($filter, $scope) {
            $filterLike = "%{$filter}%";

            return $scope->where([
                ['title', 'like', $filterLike],
            ]);
        };
        // Escopo.
        $scope = Product::orderBy('created_at', 'desc');
        // Escopo por filtro.
        $query = $filter ?
            $search($filter, $scope) :
            $scope;
        // Seleciona.
        $products = $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();

        return api_response(200, null, [
            'products' => $products
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
        $product = null;

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Product::class)) {
            return api_response(403);
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
            // Associa os projetos.
            $product->projects()->sync($inputs['projects']);
        };

        try {
            // Tenta criar.
            DB::transaction($store);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.products.created'), [
            'product' => $product
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
        $product = Product::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $product)) {
            return api_response(403);
        }
        $update = function () use ($user, $inputs, $product) {
            // Atualiza os campos por input.
            $product->update($inputs);
            // Sincroniza os projetos.
            $product->projects()->sync($inputs['projects']);
        };

        try {
            // Tenta atualizar.
            DB::transaction($update);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.products.updated'), [
            'product' => $product
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
        $product = Product::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('delete', $product)) {
            return api_response(403);
        }
        $destroy = function () use ($product) {
            $product->delete();
        };

        try {
            // Tenta atualizar.
            DB::transaction($destroy);
        } catch (Exception $exception) {
            return api_response(500);
        }

        return api_response(200, __('messages.products.deleted'));
    }    
}
