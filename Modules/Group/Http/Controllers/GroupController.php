<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Http\Requests\GroupRequest;
use Modules\Group\Repositories\GroupRepository;

class GroupController extends Controller
{
    /**
     * Repositório de dados.
     *
     * @var \Modules\User\Repositories\GroupRepository
     */
    protected $groups;

    /**
     * Quantidade de recursos por página.
     *
     * @var int
     */
    static public $perPage = 10;

    /**
     * Inicializa o controlador com a instância do repositório de dados.
     *
     * @param \Modules\User\Repositories\GroupRepository $groups
     * @return void
     */
    public function __construct(GroupRepository $groups)
    {
        $this->groups = $groups;
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
        $index = $this->groups
            ->index($user, $perPage, $query);
        
        if (!$index->success) {
            return abort($index->status);
        }

        return view('group::pages.groups.index', [
            'groups' => $index->data['groups']
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
        if ($user->cant('create', group::class)) {
            return abort(403);
        }
        $roles = Role::ofUser($user)
            ->forgroupsForm()
            ->get();

        return view('group::pages.groups.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $store = $this->groups
            ->store($user, $inputs);
        $redirectTo = 'groups/' . (
            $store->data['userCreated']->id ?? null
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
        $userToShow = group::findOrFail($id);

        // Verifica se usuário pode realizar.
        if ($user->cant('view', $userToShow)) {
            return abort(403);
        }
        $section = $request->query('section', 'about');
        
        return view('group::pages.groups.show', [
            'userToShow' => $userToShow,
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
        $userToEdit = group::findOrFail($id);

        // Verifica se o usuário pode realizar.
        if ($user->cant('update', $userToEdit)) {
            return abort(403);
        }
        $roles = Role::ofUser($user)
            ->forgroupsForm()
            ->get();

        return view('group::pages.groups.edit', [
            'userToEdit' => $userToEdit,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\User\Http\Requests\GroupRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        $user = $request->user();
        $inputs = $request->sanitize();
        $update = $this->groups
            ->update($user, (int) $id, $inputs);

        return redirect("groups/{$id}")
            ->with('snackbar', $update->message);
    }
}
