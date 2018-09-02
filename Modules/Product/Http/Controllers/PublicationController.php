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
        $user = $request->user();
        $perPage = self::$perPage;
        $query = $request->get('q');
        $index = $this->publications
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('product::pages.publications.index', [
            'publications' => $index->data['publications']
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
        $projects = Project::approved()
            ->get();
        $members = Member::with('user')
            ->get();

        return view('product::pages.publications.create', [
            'projects' => $projects,
            'members' => $members
        ]);
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

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $publication)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');

        return view('product::pages.publications.show', [
            'publication' => $publication,
            'section' => $section
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
        $projects = Project::approved()
            ->get();
        $members = Member::with('user')
            ->get();

        return view('product::pages.publications.edit', [
            'publication' => $publication,
            'projects' => $projects,
            'members' => $members,
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
