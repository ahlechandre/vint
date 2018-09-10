<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Project\Entities\Project;
use Modules\Product\Entities\Publication;
use Modules\Product\Http\Requests\PublicationRequest;
use Modules\Product\Repositories\PublicationRepository;
use Modules\Member\Entities\Member;

class PublicationController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\PublicationRepository
     */
    protected $publications;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\PublicationRepository $publications
     * @return void
     */
    public function __construct(PublicationRepository $publications)
    {
        $this->publications = $publications;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        $index = $this->publications
            ->index(self::$perPage, $query);
        
        return view('product::pages.publications.index', [
            'publications' => $index->data['publications']
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
        $query = $request->get('q');
        $projects = $this->publications
            ->projects($id, $perPage, $query);

        return view('product::pages.publications.projects', [
            'publication' => $projects->data['publication'],
            'projects' => $projects->data['projects']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request, $id)
    {
        $perPage = self::$perPage;
        $query = $request->get('q');
        $members = $this->publications
            ->members($id, $perPage, $query);

        return view('product::pages.publications.members', [
            'publication' => $members->data['publication'],
            'members' => $members->data['members']
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
        if ($user->cant('create', Publication::class)) {
            return abort(403);
        }

        return view('product::pages.publications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\PublicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublicationRequest $request)
    {
        $user = $request->user();
        $inputs = $request->all();
        $store = $this->publications
            ->store($user, $inputs);
        $redirectTo = 'publications/' . (
            $store->data['publication']->id ?? null
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
        $publication = Publication::findOrFail($id);

        return view('product::pages.publications.show', [
            'publication' => $publication
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
        $publication = Publication::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $publication)) {
            return abort(403);
        }

        return view('product::pages.publications.edit', [
            'publication' => $publication,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\PublicationRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PublicationRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->all();
        $update = $this->publications
            ->update($user, $id, $inputs);

        return redirect("publications/{$id}")
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
        $destroy = $this->publications
            ->destroy($user, $id);

        return redirect('publications')
            ->with('snackbar', $destroy->message);
    }    
}
