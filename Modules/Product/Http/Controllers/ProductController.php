<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Project\Entities\Project;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\ProductRepository
     */
    protected $products;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\ProductRepository $products
     * @return void
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $term = $request->get('q');
        $index = $this->products
            ->index(self::$perPage, $term);

        return view('product::pages.products.index', [
            'products' => $index->data['products']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function projects(Request $request, $id)
    {
        $perPage = self::$perPage;
        $term = $request->get('q');
        $projects = $this->products
            ->projects($id, $perPage, $term);

        return view('product::pages.products.projects', [
            'product' => $projects->data['product'],
            'projects' => $projects->data['projects']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        // Verifica se o usuário pode realizar.
        if ($user->cant('create', Product::class)) {
            return abort(403);
        }

        return view('product::pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->products
            ->store($user, $inputs);
        $redirectTo = 'products/' . (
            $store->data['product']->id ?? null
        );

        return redirect($redirectTo)
            ->with('snackbar', $store->message);
    }

    /**
     * Show the specified resource.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   string  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::findOrFail($id);

        return view('product::pages.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $product)) {
            return abort(403);
        }

        return view('product::pages.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\ProductRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->products
            ->update($user, (int) $id, $inputs);

        return redirect("products/{$id}")
            ->with('snackbar', $update->message);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $destroy = $this->products
            ->destroy($user, $id);

        return redirect('products')
            ->with('snackbar', $destroy->message);
    }
}
